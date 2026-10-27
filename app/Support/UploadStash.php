<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Keeps a visitor's valid uploads while a form comes back with an error, so a patient who
 * mistyped a phone number does not have to photograph their ID card again.
 *
 * Each valid file goes to the private "local" disk under stash/{random key}/, never the web
 * root, and is listed in the visitor's own session ("Attached: id.jpg"). Staff cannot open a
 * stashed file: it only becomes a submission file (with the records-only rule and access
 * logging) when the form is sent. Stashes older than 24 hours are deleted.
 */
final class UploadStash
{
    public const int KEEP_HOURS = 24;

    private const string DIR = 'stash';

    /**
     * @param  array<string, array{rules: list<mixed>, max: int}>  $fields  field => one file's rules and how many files it takes
     */
    private function __construct(private readonly Request $request, private readonly string $form, private readonly array $fields) {}

    /** @var array<string, UploadedFile|list<UploadedFile>|null> field => this request's files that failed, for the validator */
    private array $rejected = [];

    /**
     * Take in this request's uploads: valid ones are stashed; invalid ones are kept aside (see
     * input()) for the validator to report.
     * Ticked "remove" boxes (remove_attached[field][]=index) drop stashed files first.
     *
     * @param  array<string, array{rules: list<mixed>, max: int}>  $fields
     */
    public static function absorb(Request $request, string $form, array $fields): self
    {
        self::prune();
        $stash = new self($request, $form, $fields);

        $remove = $request->input('remove_attached');
        foreach ($fields as $field => $spec) {
            $drop = is_array($remove) && is_array($remove[$field] ?? null) ? array_map('intval', $remove[$field]) : [];
            $kept = [];
            foreach ($stash->entries($field) as $i => $entry) {
                in_array($i, $drop, true) ? Storage::disk('local')->delete($entry['path']) : $kept[] = $entry;
            }
            $stash->put($field, $kept);

            $raw = $request->file($field);
            $incoming = array_values(array_filter(is_array($raw) ? $raw : [$raw], fn ($f) => $f instanceof UploadedFile));
            $stash->rejected[$field] = is_array($raw) ? [] : null;
            if ($incoming === []) {
                continue;
            }
            $rejected = [];
            foreach ($incoming as $file) {
                $valid = $file->isValid() && Validator::make(['file' => $file], ['file' => $spec['rules']])->passes();
                if (! $valid || ($spec['max'] > 1 && count($kept) >= $spec['max'])) {
                    $rejected[] = $file;

                    continue;
                }
                if ($spec['max'] === 1) {
                    // A new photo replaces the one kept from the last try.
                    foreach ($kept as $old) {
                        Storage::disk('local')->delete($old['path']);
                    }
                    $kept = [];
                }
                $kept[] = [
                    'path' => (string) $file->store(self::DIR.'/'.$stash->key(), 'local'),
                    'name' => mb_substr($file->getClientOriginalName(), 0, 200),
                    'mime' => $file->getMimeType(),
                    'size' => (int) $file->getSize(),
                ];
            }
            $stash->put($field, $kept);
            $stash->rejected[$field] = is_array($raw) ? $rejected : ($rejected[0] ?? null);
        }

        return $stash;
    }

    /**
     * The request's input for the validator: everything as posted, except that file fields hold
     * only the uploads that failed (the valid ones are already stashed).
     *
     * @return array<string, mixed>
     */
    public function input(): array
    {
        return array_merge($this->request->except(array_merge(array_keys($this->fields), ['remove_attached'])), array_filter($this->rejected, fn ($v) => $v !== null));
    }

    public function has(string $field): bool
    {
        return $this->entries($field) !== [];
    }

    public function count(string $field): int
    {
        return count($this->entries($field));
    }

    /**
     * Stashed files for a field, for SubmissionIntake.
     *
     * @return list<array{path: string, name: string, mime: string|null, size: int}>
     */
    public function entries(string $field): array
    {
        return self::listed($this->request, $this->form, $field);
    }

    /** The form went through: the files now belong to a submission, so forget them here. */
    public function forget(): void
    {
        $this->request->session()->forget('upload_stash.'.$this->form);
        $key = $this->request->session()->get('upload_stash_key');
        if (is_string($key) && $key !== '' && Storage::disk('local')->allFiles(self::DIR.'/'.$key) === []) {
            Storage::disk('local')->deleteDirectory(self::DIR.'/'.$key);
        }
    }

    /**
     * What the form view shows as "Attached: …".
     *
     * @return list<array{path: string, name: string, mime: string|null, size: int}>
     */
    public static function listed(Request $request, string $form, string $field): array
    {
        if (! $request->hasSession()) {
            return [];
        }
        $list = $request->session()->get('upload_stash.'.$form.'.'.$field, []);

        // Only entries in this visitor's own stash folder that are still on disk.
        $prefix = self::DIR.'/'.$request->session()->get('upload_stash_key', '-').'/';

        return array_values(array_filter(is_array($list) ? $list : [], fn ($e) => is_array($e) && is_string($e['path'] ?? null)
            && str_starts_with($e['path'], $prefix) && Storage::disk('local')->exists($e['path'])));
    }

    /** Delete stash folders nobody has touched for a day (abandoned forms). */
    public static function prune(): void
    {
        $disk = Storage::disk('local');
        $cutoff = now()->subHours(self::KEEP_HOURS)->getTimestamp();
        foreach ($disk->directories(self::DIR) as $dir) {
            $files = $disk->allFiles($dir);
            $newest = $files === [] ? 0 : max(array_map(fn (string $f) => $disk->lastModified($f), $files));
            if ($newest < $cutoff) {
                $disk->deleteDirectory($dir);
            }
        }
    }

    /** @param  list<array{path: string, name: string, mime: string|null, size: int}>  $entries */
    private function put(string $field, array $entries): void
    {
        $this->request->session()->put('upload_stash.'.$this->form.'.'.$field, $entries);
    }

    private function key(): string
    {
        $session = $this->request->session();
        if (! is_string($key = $session->get('upload_stash_key')) || $key === '') {
            $session->put('upload_stash_key', $key = Str::random(32));
        }

        return $key;
    }
}

<?php

namespace App\Support;

use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use App\Models\Submission;
use App\Notifications\NewSubmission;
use App\Notifications\SubmissionReceived;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Every public form ends here: one submissions row with a reference, the uploads on the
 * private disk, a first timeline entry, an email to the office (or HR) and a confirmation
 * to the sender. Emails never carry clinical or personal details beyond the name.
 */
final class SubmissionIntake
{
    /**
     * @param  array<string, mixed>  $attributes
     * @param  array<string, list<UploadedFile|array{path: string, name: string, mime: string|null, size: int}>>  $files  kind => new uploads or UploadStash entries
     */
    public static function create(SubmissionType $type, array $attributes, array $files, Request $request): Submission
    {
        $submission = Submission::create($attributes + [
            'type' => $type,
            'status' => SubmissionStatus::New,
            'source_url' => mb_substr((string) $request->headers->get('referer', $request->fullUrl()), 0, 300),
        ]);

        foreach ($files as $kind => $list) {
            foreach ($list as $file) {
                if ($file instanceof UploadedFile) {
                    $file = [
                        // Random file name, private disk, one folder per submission.
                        'path' => (string) $file->store('submissions/'.$submission->id, 'local'),
                        'name' => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType(),
                        'size' => (int) $file->getSize(),
                    ];
                } else {
                    // Kept from an earlier try (UploadStash): move it into the submission's folder.
                    $to = 'submissions/'.$submission->id.'/'.basename($file['path']);
                    if (! Storage::disk('local')->move($file['path'], $to)) {
                        continue;
                    }
                    $file['path'] = $to;
                }
                $submission->files()->create([
                    'kind' => $kind,
                    'path' => $file['path'],
                    'original_name' => mb_substr($file['name'], 0, 200),
                    'mime' => $file['mime'],
                    'size' => $file['size'],
                ]);
            }
        }

        $about = $submission->subject();
        $submission->notes()->create(['kind' => 'system', 'body' => 'Received from the website'.($about ? ' about '.$about : '').'.']);

        Notify::office(new NewSubmission($submission), hr: $type === SubmissionType::Career);
        Notify::customer($submission->email, new SubmissionReceived($submission));

        // Kept (not flashed) so refreshing the thank-you page still shows the number.
        $request->session()->put('last_submission', ['reference' => $submission->reference, 'type' => $type->value]);

        return $submission;
    }

    /** Bots fill the hidden "website" field. Pretend it worked and keep nothing. */
    public static function isBot(Request $request, SubmissionType $type = SubmissionType::Enquiry): bool
    {
        if ($request->filled('website')) {
            $request->session()->put('last_submission', ['reference' => $type->prefix().'-'.now()->format('y').'-00000', 'type' => $type->value]);

            return true;
        }

        return false;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Uploads. Always on the private "local" disk. ID and insurance cards open for the
 * registration & records role only (not even administrators); every opening is logged.
 *
 * @property int $id
 * @property int $submission_id
 * @property string $kind
 * @property string $path
 * @property string $original_name
 * @property string|null $mime
 * @property int $size
 * @property-read Submission $submission
 */
class SubmissionFile extends Model
{
    /** Identity and insurance documents: records role only. */
    public const array RESTRICTED_KINDS = ['id_card', 'insurance_card'];

    protected $fillable = ['submission_id', 'kind', 'path', 'original_name', 'mime', 'size'];

    /** @return BelongsTo<Submission, $this> */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    /** @return HasMany<FileAccess, $this> */
    public function accesses(): HasMany
    {
        return $this->hasMany(FileAccess::class);
    }

    public function isRestricted(): bool
    {
        return in_array($this->kind, self::RESTRICTED_KINDS, true);
    }

    public function isImage(): bool
    {
        return str_starts_with((string) $this->mime, 'image/');
    }

    public function label(): string
    {
        return match ($this->kind) {
            'id_card' => 'ID card',
            'insurance_card' => 'Insurance card',
            'referral' => 'Referral letter',
            'cv' => 'CV',
            'certificate' => 'Certificate or licence',
            default => 'File',
        };
    }
}

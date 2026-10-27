<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * One row each time a member of staff opens an uploaded document.
 *
 * @property int $id
 * @property int $submission_file_id
 * @property int $submission_id
 * @property int|null $user_id
 * @property string|null $ip
 * @property Carbon $created_at
 * @property-read SubmissionFile $file
 * @property-read Submission $submission
 * @property-read User|null $user
 */
class FileAccess extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['submission_file_id', 'submission_id', 'user_id', 'ip'];

    /** @return BelongsTo<SubmissionFile, $this> */
    public function file(): BelongsTo
    {
        return $this->belongsTo(SubmissionFile::class, 'submission_file_id');
    }

    /** @return BelongsTo<Submission, $this> */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

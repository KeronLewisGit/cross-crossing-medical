<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $submission_id
 * @property int|null $user_id
 * @property string $kind
 * @property string $body
 * @property Carbon $created_at
 * @property-read User|null $user
 */
class SubmissionNote extends Model
{
    protected $fillable = ['submission_id', 'user_id', 'kind', 'body'];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

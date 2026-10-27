<?php

namespace App\Models;

use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $role_key
 * @property string|null $department
 * @property string $employment
 * @property JobStatus $status
 * @property string|null $summary
 * @property string|null $duties
 * @property string|null $requirements
 * @property Carbon|null $closes_on
 * @property bool $is_demo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class JobPosting extends Model
{
    protected $fillable = ['slug', 'title', 'role_key', 'department', 'employment', 'status', 'summary', 'duties', 'requirements', 'closes_on', 'is_demo'];

    #[\Override]
    protected function casts(): array
    {
        return [
            'status' => JobStatus::class,
            'closes_on' => 'date',
            'is_demo' => 'boolean',
        ];
    }

    #[\Override]
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** @return HasMany<Submission, $this> */
    public function applications(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /** @param Builder<self> $query */
    public function scopeOpen(Builder $query): void
    {
        $query->where('status', JobStatus::Open)
            ->where(fn (Builder $q) => $q->whereNull('closes_on')->orWhereDate('closes_on', '>=', today()));
    }

    public function isOpen(): bool
    {
        return $this->status === JobStatus::Open && ($this->closes_on === null || ! $this->closes_on->isPast() || $this->closes_on->isToday());
    }

    public function employmentLabel(): string
    {
        return (string) (ccmc('availability.'.$this->employment) ?? $this->employment);
    }

    /** @return list<string> */
    public function lines(string $field): array
    {
        return lines_to_array((string) $this->getAttribute($field));
    }
}

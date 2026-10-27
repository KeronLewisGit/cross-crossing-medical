<?php

namespace App\Models;

use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use Database\Factories\SubmissionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Anything a patient, relative or applicant sends through the website.
 *
 * @property int $id
 * @property string $reference
 * @property SubmissionType $type
 * @property SubmissionStatus $status
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property string $contact_pref
 * @property string|null $service_key
 * @property int|null $job_posting_id
 * @property int|null $assigned_to
 * @property Carbon|null $booked_date
 * @property string|null $booked_time
 * @property array<string, mixed>|null $details
 * @property string|null $message
 * @property Carbon|null $consented_at
 * @property string|null $source_url
 * @property Carbon|null $first_contacted_at
 * @property Carbon|null $status_changed_at
 * @property bool $is_demo
 * @property Carbon $created_at
 * @property-read JobPosting|null $jobPosting
 * @property-read User|null $assignee
 * @property-read Collection<int, SubmissionNote> $notes
 * @property-read Collection<int, SubmissionFile> $files
 */
class Submission extends Model
{
    /** @use HasFactory<SubmissionFactory> */
    use HasFactory;

    protected $fillable = [
        'type', 'status', 'name', 'phone', 'email', 'contact_pref', 'service_key', 'job_posting_id', 'assigned_to',
        'booked_date', 'booked_time', 'details', 'message', 'consented_at', 'source_url',
        'first_contacted_at', 'status_changed_at', 'is_demo',
    ];

    #[\Override]
    protected function casts(): array
    {
        return [
            'type' => SubmissionType::class,
            'status' => SubmissionStatus::class,
            'details' => 'array',
            'booked_date' => 'date',
            'consented_at' => 'datetime',
            'first_contacted_at' => 'datetime',
            'status_changed_at' => 'datetime',
            'is_demo' => 'boolean',
        ];
    }

    #[\Override]
    protected static function booted(): void
    {
        static::creating(function (self $s): void {
            $s->reference ??= 'pending-'.bin2hex(random_bytes(4));
            $s->status ??= SubmissionStatus::New;
        });
        static::created(function (self $s): void {
            $s->forceFill([
                'reference' => sprintf('%s-%s-%05d', $s->type->prefix(), $s->created_at->format('y'), $s->id),
            ])->saveQuietly();
        });
        // People type numbers every way; keep a digits-only copy so staff can search them.
        static::saving(function (self $s): void {
            $s->phone_digits = preg_replace('/\D+/', '', (string) $s->phone) ?: null;
        });
    }

    /** @return BelongsTo<JobPosting, $this> */
    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class);
    }

    /** @return BelongsTo<User, $this> */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /** @return HasMany<SubmissionNote, $this> */
    public function notes(): HasMany
    {
        return $this->hasMany(SubmissionNote::class)->latest('id');
    }

    /** @return HasMany<SubmissionFile, $this> */
    public function files(): HasMany
    {
        return $this->hasMany(SubmissionFile::class);
    }

    /** The clinic, test, department or job this is about, in words. */
    public function subject(): ?string
    {
        if ($this->type === SubmissionType::Career) {
            return $this->jobPosting->title ?? (ccmc('career_roles.'.$this->service_key) ?: null);
        }

        return self::serviceLabel($this->service_key);
    }

    /** "cardiology" → "Cardiology"; works for clinics, tests and departments. */
    public static function serviceLabel(?string $key): ?string
    {
        if (! $key) {
            return null;
        }
        $label = ccmc('clinics.'.$key) ?? ccmc('tests.'.$key) ?? ccmc('departments.'.$key.'.name');

        return is_string($label) ? $label : null;
    }

    /** The patient, when the person calling back is a parent or relative. */
    public function patientName(): string
    {
        $p = $this->detail('patient_name');

        return is_string($p) && $p !== '' ? $p : $this->name;
    }

    public function detail(string $key): mixed
    {
        return ($this->details ?? [])[$key] ?? null;
    }

    public function dueAt(): Carbon
    {
        return $this->created_at->copy()->addHours($this->type->responseHours());
    }

    public function isOverdue(): bool
    {
        return $this->status === SubmissionStatus::New && $this->dueAt()->isPast();
    }

    public function moveTo(SubmissionStatus $status): bool
    {
        if ($this->status === $status) {
            return false;
        }
        $this->status = $status;
        $this->status_changed_at = now();
        if ($status !== SubmissionStatus::New) {
            $this->first_contacted_at ??= now();
        }

        return true;
    }

    public function statusLabel(): string
    {
        return $this->status->label($this->type);
    }

    /**
     * Submissions this user's role works.
     *
     * @param  Builder<self>  $query
     */
    public function scopeVisibleTo(Builder $query, User $user): void
    {
        $query->whereIn('type', $user->typeValues());
    }

    /**
     * The inbox order: new first, then newest first.
     *
     * @param  Builder<self>  $query
     */
    public function scopeInboxOrder(Builder $query): void
    {
        $query->orderByRaw("case when status = 'new' then 0 else 1 end")->orderByDesc('id');
    }

    /**
     * Still new after the type's response window (SubmissionType::responseHours).
     *
     * @param  Builder<self>  $query
     */
    public function scopeOverdue(Builder $query): void
    {
        $query->where('status', SubmissionStatus::New)->where(function (Builder $q) {
            foreach (SubmissionType::cases() as $type) {
                $q->orWhere(fn (Builder $w) => $w->where('type', $type)->where('created_at', '<', now()->subHours($type->responseHours())));
            }
        });
    }

    /**
     * @param  Builder<self>  $query
     * @param  list<SubmissionType>  $types
     */
    public function scopeOfTypes(Builder $query, array $types): void
    {
        $query->whereIn('type', array_map(fn (SubmissionType $t) => $t->value, $types));
    }

    /**
     * @param  Builder<self>  $query
     * @param  array<string, mixed>  $f
     */
    public function scopeFilter(Builder $query, array $f): void
    {
        $query
            ->when($f['type'] ?? null, fn (Builder $q, $v) => $q->where('type', $v))
            ->when($f['status'] ?? null, fn (Builder $q, $v) => $v === 'open'
                ? $q->whereIn('status', [SubmissionStatus::New, SubmissionStatus::Contacted, SubmissionStatus::Booked])
                : $q->where('status', $v))
            ->when($f['service'] ?? null, fn (Builder $q, $v) => $q->where('service_key', $v))
            ->when($f['assigned'] ?? null, fn (Builder $q, $v) => $v === 'none' ? $q->whereNull('assigned_to') : $q->where('assigned_to', $v))
            ->when($f['overdue'] ?? null, fn (Builder $q) => $q->overdue())
            ->when($f['q'] ?? null, function (Builder $q, $term) {
                $like = '%'.str_replace(['%', '_'], ['\%', '\_'], (string) $term).'%';
                $digits = preg_replace('/\D+/', '', (string) $term);
                $q->where(function (Builder $w) use ($like, $digits) {
                    $w->where('name', 'like', $like)->orWhere('reference', 'like', $like)->orWhere('email', 'like', $like);
                    if (strlen((string) $digits) >= 3) {
                        $w->orWhere('phone_digits', 'like', '%'.$digits.'%');
                    }
                });
            });
    }
}

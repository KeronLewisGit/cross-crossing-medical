<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Patient handouts library. Each one is either a link to the publisher's own copy
 * or a PDF uploaded by staff to the public "uploads" disk (handouts are public by nature).
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $category
 * @property string|null $summary
 * @property string|null $publisher
 * @property string|null $url
 * @property string|null $file_path
 * @property int|null $file_size
 * @property bool $published
 * @property int $sort
 */
class Handout extends Model
{
    public const array CATEGORIES = [
        'heart' => 'Heart and blood pressure',
        'diabetes' => 'Diabetes and nutrition',
        'bones' => 'Bones and joints',
        'vaccines' => 'Vaccinations',
        'general' => 'General health',
    ];

    protected $fillable = ['slug', 'title', 'category', 'summary', 'publisher', 'url', 'file_path', 'file_size', 'published', 'sort'];

    #[\Override]
    protected function casts(): array
    {
        return ['published' => 'boolean', 'sort' => 'integer', 'file_size' => 'integer'];
    }

    /** @param Builder<self> $query */
    public function scopePublished(Builder $query): void
    {
        $query->where('published', true)->where(fn (Builder $q) => $q->whereNotNull('url')->orWhereNotNull('file_path'));
    }

    public function href(): ?string
    {
        return $this->file_path ? asset('uploads/'.$this->file_path) : $this->url;
    }

    public function isExternal(): bool
    {
        return $this->file_path === null && $this->url !== null;
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? 'General health';
    }

    public function host(): ?string
    {
        $host = $this->url ? parse_url($this->url, PHP_URL_HOST) : null;

        return is_string($host) ? preg_replace('/^www\./', '', $host) : null;
    }
}

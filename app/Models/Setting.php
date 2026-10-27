<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Small name/value store for things the centre changes without a developer:
 * the public notice band (e.g. a change to clinic days over a holiday).
 *
 * @property string $name
 * @property string|null $value
 */
class Setting extends Model
{
    protected $primaryKey = 'name';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['name', 'value'];

    /** @var array<string, string|null> */
    private static array $cache = [];

    public static function get(string $key, ?string $default = null): ?string
    {
        if (! array_key_exists($key, self::$cache)) {
            self::$cache[$key] = self::query()->whereKey($key)->value('value');
        }
        $value = self::$cache[$key];

        return $value === null || $value === '' ? $default : $value;
    }

    public static function put(string $key, ?string $value): void
    {
        self::query()->updateOrCreate(['name' => $key], ['value' => $value]);
        self::$cache[$key] = $value;
    }

    public static function flush(): void
    {
        self::$cache = [];
    }

    /** The notice shown in a band on every public page, or null for none. */
    public static function notice(): ?string
    {
        $text = trim((string) self::get('public_notice'));

        return $text === '' ? null : $text;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key with optional default.
     * Cached for 60 minutes.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember('setting_' . $key, 3600, function () use ($key, $default) {
            $row = self::where('key', $key)->first();
            return $row ? $row->value : $default;
        });
    }

    /**
     * Set (upsert) a setting value and clear its cache.
     */
    public static function set(string $key, mixed $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('setting_' . $key);
    }
}
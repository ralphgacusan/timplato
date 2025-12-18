<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'setting_id';
    public $incrementing = true; // <-- keep true since it's an auto ID (important!)
    protected $keyType = 'int';
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set($key, $value)
    {
        // 👇 use this instead of updateOrCreate
        $setting = static::where('key', $key)->first();
        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            static::create(['key' => $key, 'value' => $value]);
        }
    }
}

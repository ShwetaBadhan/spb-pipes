<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'flag',
        'is_rtl',
        'is_default',
        'is_active',
        'web_enabled',
        'app_enabled',
        'admin_enabled',
    ];

    protected $casts = [
        'is_rtl' => 'boolean',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'web_enabled' => 'boolean',
        'app_enabled' => 'boolean',
        'admin_enabled' => 'boolean',
    ];

    /**
     * Boot method to ensure only one default language
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($language) {
            if ($language->is_default && $language->isDirty('is_default')) {
                static::where('id', '!=', $language->id)->update(['is_default' => false]);
            }
        });

        static::created(function ($language) {
            if ($language->is_default) {
                static::where('id', '!=', $language->id)->update(['is_default' => false]);
            }
        });
    }

    /**
     * Get flag URL
     */
    public function getFlagUrlAttribute()
    {
        return $this->flag ? asset($this->flag) : asset('assets/img/flags/' . $this->code . '.svg');
    }
}
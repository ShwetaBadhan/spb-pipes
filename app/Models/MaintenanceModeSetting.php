<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class MaintenanceModeSetting extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'image_path',
        'meta_description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Accessor for full image URL
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    /**
     * Get the singleton settings record (first or create)
     */
    public static function getOrCreate(): self
    {
        return static::firstOrCreate([]);
    }
}
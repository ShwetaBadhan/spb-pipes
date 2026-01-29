<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class LaborType extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'category',
        'rate_type',
        'rate_amount',
        'unit_type',
        'work_type',
        'description',
        'is_active',
        'status',
        'sort_order'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'rate_amount' => 'decimal:2',
        'sort_order' => 'integer',
        'deleted_at' => 'datetime'
    ];

    /**
     * Appended attributes.
     *
     * @var array<int, string>
     */
    protected $appends = ['display_name', 'status_label'];

    /**
     * Get the display name attribute.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->code ? "{$this->code} - {$this->name}" : $this->name;
    }

    /**
     * Get the status label attribute.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'active' ? 'Active' : 'Inactive';
    }

    /**
     * Scope a query to only include active labor types.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive labor types.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to only include production labor types.
     */
    public function scopeProduction($query)
    {
        return $query->where('category', 'production');
    }

    /**
     * Scope a query to only include logistics labor types.
     */
    public function scopeLogistics($query)
    {
        return $query->where('category', 'logistics');
    }

    /**
     * Activate the labor type.
     */
    public function activate(): bool
    {
        $this->status = 'active';
        $this->is_active = true;
        return $this->save();
    }

    /**
     * Deactivate the labor type.
     */
    public function deactivate(): bool
    {
        $this->status = 'inactive';
        $this->is_active = false;
        return $this->save();
    }

    /**
     * Toggle the status of the labor type.
     */
    public function toggleStatus(): bool
    {
        if ($this->status === 'active') {
            return $this->deactivate();
        }
        return $this->activate();
    }

    /**
     * Get all possible statuses.
     */
    public static function getStatuses(): array
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive'
        ];
    }

    /**
     * Get all possible categories.
     */
    public static function getCategories(): array
    {
        return [
            'production' => 'Production',
            'logistics' => 'Logistics'
        ];
    }

    /**
     * Get all possible rate types.
     */
    public static function getRateTypes(): array
    {
        return [
            'per_unit' => 'Per Unit',
            'per_truck' => 'Per Truck',
            'per_hour' => 'Per Hour',
            'per_batch' => 'Per Batch',
            'per_worker' => 'Per Worker'
        ];
    }

    /**
     * Get all possible unit types.
     */
    public static function getUnitTypes(): array
    {
        return [
            'tile' => 'Tile',
            'pipe' => 'Pipe',
            'batch' => 'Batch',
            'other' => 'Other'
        ];
    }

    /**
     * Get all possible work types.
     */
    public static function getWorkTypes(): array
    {
        return [
            'loading' => 'Loading',
            'unloading' => 'Unloading',
            'both' => 'Both',
            'none' => 'None'
        ];
    }
}
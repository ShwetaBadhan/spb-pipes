<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaborType extends Model
{
    use SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'name',
        'code',
        'category',
        'rate_type_id',
        'rate_amount',
        'unit_id',
        'work_type_id',
        'description',
        'is_active',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ✅ Relationships
    public function rateType()
    {
        return $this->belongsTo(RateType::class, 'rate_type_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class, 'work_type_id');
    }

    // ✅ Helper methods
    public function getRateTypeNameAttribute()
    {
        return $this->rateType ? $this->rateType->name : 'N/A';
    }

    public function getUnitNameAttribute()
    {
        return $this->unit ? $this->unit->name : 'N/A';
    }

    public function getWorkTypeNameAttribute()
    {
        return $this->workType ? $this->workType->name : 'N/A';
    }

    // ✅ Status toggle methods
    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
        $this->status = $this->is_active ? 'active' : 'inactive';
        return $this->save();
    }

    public function activate()
    {
        $this->is_active = true;
        $this->status = 'active';
        return $this->save();
    }

    public function deactivate()
    {
        $this->is_active = false;
        $this->status = 'inactive';
        return $this->save();
    }
     public function gatePasses()
    {
        return $this->hasMany(GatePass::class);
    }
}
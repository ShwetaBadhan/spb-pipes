<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;


class RawMaterial extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'material_name',
        'unit_id',
        'min_stock'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }
}

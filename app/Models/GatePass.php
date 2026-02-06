<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number',
        'type', // <-- ADD THIS
        'date',
        'product_id',
        'labor_type_id',
        'quantity',
        'workers_count',
        'rate_amount',
        'total_cost',
        'remarks'
    ];

    protected $casts = [
        'date' => 'date',
        'rate_amount' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];
// Helper methods for type
public function isInward()
{
    return $this->type === 'inward';
}

public function isOutward()
{
    return $this->type === 'outward';
}

// Scope methods
public function scopeInward($query)
{
    return $query->where('type', 'inward');
}

public function scopeOutward($query)
{
    return $query->where('type', 'outward');
}
    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function laborType()
    {
        return $this->belongsTo(LaborType::class);
    }

    // Scope to get all entries for a specific vehicle/batch
    public function scopeByBatch($query, $batchNumber)
    {
        return $query->where('batch_number', $batchNumber);
    }

    // Calculate total cost for a batch
    public static function getTotalCostByBatch($batchNumber)
    {
        return self::where('batch_number', $batchNumber)->sum('total_cost');
    }
}
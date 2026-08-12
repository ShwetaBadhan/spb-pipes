<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaborCostAssignment extends Model
{
    use SoftDeletes, HasFactory, BelongsToTenant;

    protected $fillable = [
        'date',
        'labor_type_id',
        'product_id',
        'batch_number',
        'quantity',
        'rate_amount',
        'total_cost',
        'supervisor_id',
        'workers_count',
        'shift',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'quantity' => 'decimal:2',
        'rate_amount' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    // Relationships
    public function laborType()
    {
        return $this->belongsTo(LaborType::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class); // Update with your actual Product model
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getFormattedTotalCostAttribute()
    {
        return '₹' . number_format($this->total_cost, 2);
    }

    // Scopes
    public function scopeProduction($query)
    {
        return $query->whereHas('laborType', function ($q) {
            $q->where('category', 'production');
        });
    }

    public function scopeLogistics($query)
    {
        return $query->whereHas('laborType', function ($q) {
            $q->where('category', 'logistics');
        });
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }
    public function getFormattedDateAttribute()
{
    return $this->date->format('Y-m-d');
}
}
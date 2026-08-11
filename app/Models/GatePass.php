<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'customer_id',
        'invoice_id',
        'batch_number',
        'type',
        'date',
        'product_id',
        'labor_type_id',
        'quantity',
        'workers_count',
        'rate_amount',
        'total_cost',
        'remarks',
    ];
       // ✅ Add this: Cast date field to Carbon instance
    protected $casts = [
        'date' => 'date',
    ];


    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function laborType()
    {
        return $this->belongsTo(LaborType::class);
    }

    // ✅ Added: Get total cost by batch number
    public static function getTotalCostByBatch($batchNumber)
    {
        return self::where('batch_number', $batchNumber)->sum('total_cost');
    }
}
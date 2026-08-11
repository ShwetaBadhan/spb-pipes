<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_name',
        'item_type',
        'quantity',
        'unit',
        'rate',
        'discount_percent',
        'discount_amount',
        'amount',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'rate' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'amount' => 'decimal:2',
    ];
}
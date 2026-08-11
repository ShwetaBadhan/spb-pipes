<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTax extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'tax_name',
        'tax_type',
        'tax_rate',
        'taxable_amount',
        'tax_amount',
    ];

    protected $casts = [
        'tax_rate' => 'decimal:2',
        'taxable_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];
}
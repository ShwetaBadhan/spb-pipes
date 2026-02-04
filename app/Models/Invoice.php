<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'reference_number',
        'invoice_date',
        'due_date',
        'customer_id',
        'created_by',
        'subtotal',
        'total_tax',
        'discount_amount',
        'shipping_cost',
        'grand_total',
        'tax_type',
        'status',
        'payment_mode',
        'notes',
        'round_off',
        'round_off_amount',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'round_off' => 'boolean',
        'subtotal' => 'decimal:2',
        'total_tax' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'round_off_amount' => 'decimal:2',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function taxes()
    {
        return $this->hasMany(InvoiceTax::class);
    }
    
    // ✅ Helper: Check if invoice is overdue
    public function getIsOverdueAttribute()
    {
        return $this->status === 'unpaid' && $this->due_date && $this->due_date->isPast();
    }
    
    // ✅ Helper: Get status badge class
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'paid' => 'success',
            'unpaid' => 'warning',
            'draft' => 'info',
            'overdue' => 'danger',
            'cancelled' => 'danger',
            'partially_paid' => 'info',
            'refunded' => 'success'
        ];
        
        return $classes[$this->status] ?? 'secondary';
    }
    
    // ✅ Helper: Get status icon
    public function getStatusIconAttribute()
    {
        $icons = [
            'paid' => 'isax isax-tick-circle',
            'unpaid' => 'isax isax-slash',
            'draft' => 'isax isax-note',
            'overdue' => 'isax isax-danger',
            'cancelled' => 'isax isax-close-circle',
            'partially_paid' => 'isax isax-timer',
            'refunded' => 'isax isax-money-3'
        ];
        
        return $icons[$this->status] ?? 'isax isax-information';
    }
}
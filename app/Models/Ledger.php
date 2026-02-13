<?php

// app/Models/Ledger.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ledger extends Model
{
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'user_id',
        'transaction_type',
        'debit',
        'credit',
        'balance',
        'reference_type',
        'reference_id',
        'payment_mode',
        'transaction_id',
        'notes',
    ];

    protected $casts = [
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    // Relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeForInvoice($query, $invoiceId)
    {
        return $query->where('invoice_id', $invoiceId)->orderBy('created_at', 'asc');
    }

    public function scopePaymentReceived($query)
    {
        return $query->where('transaction_type', 'payment_received');
    }

    // Accessors
    public function getTransactionTypeBadgeAttribute()
    {
        $badges = [
            'invoice_created' => 'bg-info',
            'payment_received' => 'bg-success',
            'refund' => 'bg-warning',
            'adjustment' => 'bg-secondary',
        ];
        
        return $badges[$this->transaction_type] ?? 'bg-secondary';
    }

    public function getTransactionTypeLabelAttribute()
    {
        $labels = [
            'invoice_created' => 'Invoice Created',
            'payment_received' => 'Payment Received',
            'refund' => 'Refund',
            'adjustment' => 'Adjustment',
        ];
        
        return $labels[$this->transaction_type] ?? 'Unknown';
    }
}

<?php

namespace App\Models;

use App\Models\Ledger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth; // ✅ ADD THIS IMPORT
use Illuminate\Support\Facades\Log;
use Exception;

class Invoice extends Model
{
    use HasFactory;

    // app/Models/Invoice.php
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
        'notes',
        'round_off',
        'round_off_amount',
        'enable_tax', // ✅ ADD THIS
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
    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }

    // ✅ Create ledger entry when invoice is created


    // ✅ Create ledger entry
    // app/Models/Invoice.php

 public function createLedgerEntry($type, $debit, $credit, $notes = null, $paymentMode = null, $transactionId = null)
{
    // ✅ Get the last ledger entry for this invoice (if any)
    $lastLedger = Ledger::where('invoice_id', $this->id)
        ->orderBy('id', 'desc')
        ->first();
    
    $previousBalance = $lastLedger ? $lastLedger->balance : 0;
    
    // ✅ ALWAYS calculate balance the same way (NO special case for invoice_created)
    $newBalance = $previousBalance + $debit - $credit;
    
    // ✅ Prevent negative balance (except for refunds/adjustments)
    if ($newBalance < 0 && !in_array($type, ['refund', 'adjustment'])) {
        throw new \Exception("Cannot create ledger entry: Balance would be negative (₹" . number_format($newBalance, 2) . ")");
    }
    
    return Ledger::create([
        'invoice_id' => $this->id,
        'customer_id' => $this->customer_id,
        'user_id' => Auth::id() ?? 1,
        'transaction_type' => $type,
        'debit' => $debit,
        'credit' => $credit,
        'balance' => $newBalance,
        'payment_mode' => $paymentMode,
        'transaction_id' => $transactionId,
        'notes' => $notes ?? "Invoice {$this->invoice_number} - {$type}",
    ]);
}
    // ✅ Record payment
    public function recordPayment($amount, $paymentMode = null, $transactionId = null, $notes = null)
    {
        if ($amount <= 0) {
            throw new \Exception('Payment amount must be greater than 0');
        }

        // ✅ FIX: Calculate outstanding from invoice data
        $totalPaid = Ledger::where('invoice_id', $this->id)
            ->where('transaction_type', 'payment_received')
            ->sum('credit');

        $outstanding = $this->grand_total - $totalPaid;

        if ($amount > $outstanding) {
            throw new \Exception("Payment amount cannot exceed outstanding balance of ₹" . number_format($outstanding, 2));
        }

        // Create ledger entry
        $this->createLedgerEntry(
            'payment_received',
            0,
            $amount,
            $notes ?? "Payment received via {$paymentMode}",
            $paymentMode,
            $transactionId
        );

        // Update invoice status
        $this->updatePaymentStatus();
    }

    // ✅ Update payment status based on ledger
    public function updatePaymentStatus()
    {
        $totalPaid = Ledger::where('invoice_id', $this->id)
            ->where('transaction_type', 'payment_received')
            ->sum('credit');

        $totalDue = $this->grand_total;

        // ✅ FIX: Use >= for paid status to handle exact payments
        if ($totalPaid >= $totalDue) {
            $this->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $this->update(['status' => 'partially_paid']);
        } else {
            $this->update(['status' => 'unpaid']);
        }
    }

    // ✅ Accessors
    public function getTotalPaidAttribute()
    {
        return Ledger::where('invoice_id', $this->id)
            ->where('transaction_type', 'payment_received')
            ->sum('credit');
    }

    public function getOutstandingAmountAttribute()
    {
        return $this->grand_total - $this->total_paid;
    }

    public function getPaymentHistoryAttribute()
    {
        return Ledger::where('invoice_id', $this->id)
            ->where('transaction_type', 'payment_received')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

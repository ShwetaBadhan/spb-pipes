<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BillingInvoice extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'stripe_invoice_id',
        'amount',
        'currency',
        'status',
        'pdf_path',
        'invoice_date',
        'due_date',
    ];

    protected $casts = [
        'amount' => 'float',
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}

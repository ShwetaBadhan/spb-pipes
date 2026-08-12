<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'account_holder_name',
        'bank_name',
        'branch_name',
        'account_number',
        'aba_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Mask account number for display
    public function getMaskedAccountAttribute()
    {
        $number = $this->account_number;
        if (strlen($number) > 4) {
            return str_repeat('*', strlen($number) - 4) . substr($number, -4);
        }
        return $number;
    }
}
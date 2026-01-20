<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ← Must be imported
class InventoryLog extends Model
{
    use HasFactory;
use SoftDeletes; // ← Must be used

    protected $fillable = [
        'product_id',
        'quantity',
        'status',
        // Add other fields like user_id, reference, etc.
    ];

    // Optional: if you want to auto-convert status to lowercase
    protected $casts = [
        'status' => 'string',
    ];
     // Optional: cast dates if needed
    protected $dates = ['deleted_at'];
      // ✅ Add this relationship
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
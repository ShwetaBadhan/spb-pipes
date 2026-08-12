<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;
    
    protected $fillable = [
        'order_number', 'salesman_id', 
        'customer_name', 'customer_phone', 'customer_email', 'customer_address',
        'status', 'subtotal', 'tax', 'shipping_cost', 'total', 'notes'
    ];
    
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];
    
    // Relationship
    public function salesman()
    {
        return $this->belongsTo(User::class, 'salesman_id');
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    // Scopes
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('order_number', 'like', '%'.$search.'%')
              ->orWhere('customer_name', 'like', '%'.$search.'%')
              ->orWhere('customer_phone', 'like', '%'.$search.'%');
        });
    }
    
    public function scopeBySalesman($query, $salesmanId)
    {
        return $query->where('salesman_id', $salesmanId);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','email','phone',

        'billing_name','billing_address','billing_country',
        'billing_state','billing_city','billing_pincode',

        'shipping_name','shipping_address','shipping_country',
        'shipping_state','shipping_city','shipping_pincode',

        'bank_name','branch','account_holder','account_number','ifsc',
    ];
    // Customer.php
public function billingStateRelation()
{
    return $this->belongsTo(State::class, 'billing_state');
}

public function billingCityRelation()
{
    return $this->belongsTo(City::class, 'billing_city');
}

public function shippingStateRelation()
{
    return $this->belongsTo(State::class, 'shipping_state');
}

public function shippingCityRelation()
{
    return $this->belongsTo(City::class, 'shipping_city');
}

}

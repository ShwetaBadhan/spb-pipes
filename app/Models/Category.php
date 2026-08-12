<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];
}

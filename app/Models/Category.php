<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

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

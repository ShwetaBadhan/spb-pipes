<?php

namespace App\Models;
use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'email',
        'api_key',
        'secret_key',
        'is_active',
        'is_connected',
        'additional_data',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_connected' => 'boolean',
        'additional_data' => 'array',
    ];

  public static function initializeDefaults()
    {
        $defaults = self::getDefaultMethods();
        
        foreach ($defaults as $method) {
            self::getOrCreate($method['slug'], $method);
        }
    }

}

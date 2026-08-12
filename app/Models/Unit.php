<?php
namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'name',
        'short_name',
        'is_active',
    ];
     public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class);
    }
}

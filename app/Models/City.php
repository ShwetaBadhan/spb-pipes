<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = ['state_id', 'name', 'code'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}

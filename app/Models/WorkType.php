<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WorkType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'status'];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug on create/update
        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            } else {
                $model->slug = Str::slug($model->slug);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function activate(): bool
    {
        $this->status = 'active';
        return $this->save();
    }

    public function deactivate(): bool
    {
        $this->status = 'inactive';
        return $this->save();
    }
}
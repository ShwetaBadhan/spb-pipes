<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $fillable = [
        'name','slug','category_id','description','image_path','unit_id','code', 'status'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    // Product.php

public function category()
{
    return $this->belongsTo(Category::class);
}

public function unit()
{
    // Since you're storing unit_id as short_name (string), not ID
    return $this->belongsTo(Unit::class, 'unit_id', 'short_name');
}
public function variants()
{
    return $this->hasMany(ProductVariant::class, 'product_id');
}

    // ✅ Product → Gallery Images
    public function gallery()
    {
        return $this->hasMany(ProductImage::class);
    }
public function inventoryLogs()
{
    return $this->hasMany(InventoryLog::class, 'product_id');
}
public function productionRule()
{
    return $this->hasOne(ProductionRule::class);
}
 public function productionRecipes()
    {
        return $this->hasMany(ProductionRecipe::class);
    }
}

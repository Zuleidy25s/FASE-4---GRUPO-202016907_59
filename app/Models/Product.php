<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'status','code','name','slug','category_id',
        'file_path','image','in_discount','discount','content'
    ];

    // Categories
    public function cat(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    // En tu modelo Product
    public function getSubcategory(){
        return $this->hasOne(Category::class, 'id', 'subcategory_id');
    }
    // Gallery img
    public function getGallery(){
        return $this->hasMany(ProductGallery::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // Inventory product
    public function getInventory() {
        return $this->hasMany(Inventory::class, 'product_id', 'id')->orderby('price', 'Asc');
    }
    // Price Inventory
    public function getPrice() {
        return $this->hasMany(Inventory::class, 'product_id', 'id');
    }
    
}

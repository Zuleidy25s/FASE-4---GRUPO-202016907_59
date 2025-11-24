<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['delete_at'];
    protected $table = 'product_inventory_variants';
    protected $hidden = ['created_at', 'updated_at'];

    public function getInventory(){
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

}

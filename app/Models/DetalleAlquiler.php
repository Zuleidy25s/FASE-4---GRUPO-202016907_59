<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAlquiler extends Model
{
    use HasFactory;
    
    protected $table = 'detalle_alquiler';
    protected $primaryKey = 'id_detalle';
    
    protected $fillable = [
        'id_alquiler', 
        'id_item', 
        'cantidad', 
        'costo_subtotal',
    ];

    // Relaciones:
    
    // El Detalle pertenece a un Alquiler
    public function alquiler()
    {
        return $this->belongsTo(Alquiler::class, 'id_alquiler', 'id_alquiler');
    }

    // El Detalle pertenece a un Ítem
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}
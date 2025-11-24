<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'items';

    // Clave primaria
    protected $primaryKey = 'id_item';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre_item', 
        'tipo_servicio', 
        'descripcion', 
        'costo_unitario', 
        'cantidad_total', 
        'es_alquilable',
    ];

    // Relaciones:
    
    // Un Ítem puede estar en muchos Detalles de Alquiler
    public function detalles()
    {
        return $this->hasMany(DetalleAlquiler::class, 'id_item');
    }
    
    // Un Ítem puede tener muchos Bloqueos de Calendario
    public function bloqueos()
    {
        return $this->hasMany(BloqueoCalendario::class, 'id_item');
    }
}
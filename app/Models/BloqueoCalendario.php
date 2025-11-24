<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloqueoCalendario extends Model
{
    use HasFactory;
    
    protected $table = 'bloqueos_calendario';
    protected $primaryKey = 'id_bloqueo';
    
    protected $fillable = [
        'id_item', 
        'fecha_inicio_bloqueo', 
        'fecha_fin_bloqueo', 
        'id_alquiler', 
        'motivo',
    ];

    protected $casts = [
        'fecha_inicio_bloqueo' => 'datetime',
        'fecha_fin_bloqueo' => 'datetime',
    ];

    // Relaciones:
    
    // El Bloqueo pertenece a un Ítem
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
    
    // El Bloqueo puede pertenecer a un Alquiler (nullable)
    public function alquiler()
    {
        return $this->belongsTo(Alquiler::class, 'id_alquiler', 'id_alquiler');
    }
}
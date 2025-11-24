<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    use HasFactory;
    
    protected $table = 'alquileres';
    protected $primaryKey = 'id_alquiler';
    
    protected $fillable = [
        'user_id', 
        'estado_alquiler', 
        'fecha_reserva', 
        'hora_inicio', 
        'hora_fin', 
        'tipo_entrega', 
        'direccion_entrega', 
        'total_a_pagar',
    ];

    // Casting para fechas y horas si es necesario
    protected $casts = [
        'fecha_reserva' => 'date',
        // 'hora_inicio' => 'time', // Laravel no tiene 'time', se maneja como string
        // 'hora_fin' => 'time',
    ];
    
    // Relaciones:

    // Un Alquiler pertenece a un Usuario (asumiendo modelo User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Un Alquiler tiene muchos Detalles de Alquiler
    public function detalles()
    {
        return $this->hasMany(DetalleAlquiler::class, 'id_alquiler');
    }

    // Un Alquiler puede tener un Pago (relación uno a uno o uno a muchos si hay reintentos)
    // Usaremos hasOne si solo se registra el pago exitoso final.
    public function pago()
    {
        return $this->hasOne(Pago::class, 'id_alquiler');
    }
    
    // Un Alquiler genera Bloqueos de Calendario
    public function bloqueos()
    {
        return $this->hasMany(BloqueoCalendario::class, 'id_alquiler');
    }
}
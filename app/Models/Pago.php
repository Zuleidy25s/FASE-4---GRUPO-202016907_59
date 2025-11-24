<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    
    protected $fillable = [
        'id_alquiler', 
        'medio_pago', 
        'monto_pagado', 
        'fecha_pago', 
        'referencia_transaccion',
    ];

    // Relaciones:
    
    // Un Pago pertenece a un Alquiler
    public function alquiler()
    {
        return $this->belongsTo(Alquiler::class, 'id_alquiler', 'id_alquiler');
    }
}
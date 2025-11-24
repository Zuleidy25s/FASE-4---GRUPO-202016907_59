<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    use HasFactory;

    protected $table = 'product_galleries'; // Nombre de la tabla en la base de datos

    protected $fillable = [ // Columnas que se pueden asignar masivamente
        'product_id',
        'file_path',
        'file_name',
    ];
}
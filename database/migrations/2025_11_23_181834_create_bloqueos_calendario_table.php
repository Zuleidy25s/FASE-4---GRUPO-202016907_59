<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bloqueos_calendario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_item')->constrained('items', 'id')->onDelete('cascade');
            
            $table->dateTime('fecha_inicio_bloqueo');
            $table->dateTime('fecha_fin_bloqueo');
            
            $table->foreignId('id_alquiler')->nullable()->constrained('alquileres', 'id')->onDelete('set null');
            
            $table->string('motivo', 100);
            $table->timestamps();
            
            // Índice con nombre corto
            $table->index(['id_item', 'fecha_inicio_bloqueo', 'fecha_fin_bloqueo'], 'idx_bloqueo_item_fechas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloqueos_calendario');
    }
};

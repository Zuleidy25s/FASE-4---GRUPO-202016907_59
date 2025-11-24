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
        Schema::create('detalle_alquiler', function (Blueprint $table) {
            $table->id();
            // FK a Alquileres
            $table->foreignId('id_alquiler')->constrained('alquileres', 'id')->onDelete('cascade');
            // FK a Items
            $table->foreignId('id_item')->constrained('items', 'id')->onDelete('cascade');
            
            $table->integer('cantidad');
            $table->decimal('costo_subtotal', 10, 2);
            $table->timestamps();

            // Clave única compuesta para evitar duplicados en la misma reserva
            $table->unique(['id_alquiler', 'id_item']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_alquiler');
    }
};

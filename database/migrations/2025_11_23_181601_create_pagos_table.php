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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            // FK a Alquileres
            $table->foreignId('id_alquiler')->constrained('alquileres', 'id')->onDelete('cascade');
            
            $table->string('medio_pago', 50); // 'Efectivo', 'Billetera Digital'
            $table->decimal('monto_pagado', 10, 2);
            $table->dateTime('fecha_pago')->useCurrent();
            $table->string('referencia_transaccion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};

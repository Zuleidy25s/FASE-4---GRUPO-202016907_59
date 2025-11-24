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
        Schema::create('alquileres', function (Blueprint $table) {
            $table->id();
            // Usamos 'user_id' como convención de Laravel, asumiendo FK a users.id
            $table->foreignId('user_id')->constrained('users'); // FK a la tabla 'users'
            
            $table->dateTime('fecha_creacion')->useCurrent(); // Usar useCurrent() para auto-registro
            $table->string('estado_alquiler', 50); // 'Pendiente Pago', 'Confirmado', etc.
            
            $table->date('fecha_reserva');
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();
            
            $table->string('tipo_entrega', 50); // 'Retiro en el lugar' o 'Servicio a Domicilio'
            $table->string('direccion_entrega')->nullable();
            $table->decimal('total_a_pagar', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquileres');
    }
};

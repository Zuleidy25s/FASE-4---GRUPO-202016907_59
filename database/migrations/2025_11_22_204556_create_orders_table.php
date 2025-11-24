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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Número de ticket / número de orden
            $table->string('order_number')->unique();

            // Tipo de pedido
            $table->enum('type', ['comer_aqui', 'para_llevar']);

            // Información personal
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();

            // Forma de pago
            $table->enum('payment_method', ['rapida', 'manual']);

            // Estado del pago (para integrar un pago online)
            $table->enum('payment_status', ['pendiente', 'pagado', 'fallido'])->default('pendiente');

            // Estado del pedido
            $table->enum('status', ['pendiente', 'preparando', 'completado', 'cancelado'])
                ->default('pendiente');

            // QR generado
            $table->string('qr_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

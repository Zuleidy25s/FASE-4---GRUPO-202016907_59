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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');

            // ID que devuelve la pasarela (PayU, Stripe, MercadoPago, etc)
            $table->string('transaction_id')->nullable();

            // Referencia generada por la tienda
            $table->string('reference')->nullable();

            // Nombre de la pasarela usada
            $table->string('gateway')->nullable(); // stripe, payu, mercado_pago

            // Comprobante: puede ser JSON, PDF o imagen
            $table->string('receipt_path')->nullable(); // archivo
            $table->json('payment_data')->nullable();  // datos completos

            // Estado real del pago
            $table->enum('status', ['pendiente', 'pagado', 'rechazado', 'fallido'])
                ->default('pendiente');

            // Valor pagado
            $table->decimal('amount', 12, 2);

            $table->timestamps();

            // Relación
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};

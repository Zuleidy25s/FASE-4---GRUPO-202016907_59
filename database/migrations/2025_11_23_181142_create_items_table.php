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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_item', 150);
            $table->string('tipo_servicio', 50); // 'Comunal', 'Enseres'
            $table->text('descripcion')->nullable();
            $table->decimal('costo_unitario', 10, 2);
            $table->integer('cantidad_total')->default(0);
            $table->boolean('es_alquilable')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

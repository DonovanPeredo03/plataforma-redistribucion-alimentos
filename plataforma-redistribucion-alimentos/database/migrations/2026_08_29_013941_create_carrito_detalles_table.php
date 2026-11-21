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
        Schema::create('carrito_detalles', function (Blueprint $table) {
            $table->integer('id_detalle_carrito')->primary();
            $table->integer('id_alimento');
            $table->integer('id_carrito');

            $table->decimal('cantidad', 10, 2);

            $table->foreign('id_alimento')
                ->references('id_alimento')
                ->on('alimentos')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_carrito')
                ->references('id_carrito')
                ->on('carritos')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_detalles');
    }
};
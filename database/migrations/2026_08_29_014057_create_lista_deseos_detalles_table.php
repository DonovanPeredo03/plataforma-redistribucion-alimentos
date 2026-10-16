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
        Schema::create('lista_deseos_detalles', function (Blueprint $table) {
            $table->integer('id_detalle_lista')->primary();
            $table->integer('id_lista');
            $table->integer('id_alimento');

            $table->dateTime('fecha_agregado');

            $table->foreign('id_lista')
                ->references('id_lista')
                ->on('lista_deseos')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_alimento')
                ->references('id_alimento')
                ->on('alimentos')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_deseos_detalles');
    }
};
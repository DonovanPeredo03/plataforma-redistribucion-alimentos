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
        Schema::create('orden_detalle', function (Blueprint $table) {
            $table->integer('id_detalle_orden')->primary();
            $table->integer('id_alimento');
            $table->integer('id_orden');

            $table->decimal('cantidad', 10, 2);

            $table->foreign('id_alimento')
                ->references('id_alimento')
                ->on('alimentos')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_orden')
                ->references('id_orden')
                ->on('ordenes')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_detalle');
    }
};
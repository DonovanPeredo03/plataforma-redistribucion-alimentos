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
        Schema::create('alimentos', function (Blueprint $table) {
            $table->integer('id_alimento')->primary();
            $table->integer('id_usuario');

            $table->string('nombre', 150);
            $table->text('descripcion');
            $table->string('categoria', 100);
            $table->decimal('cantidad', 10, 2);
            $table->string('unidad', 30);
            $table->dateTime('fecha_publicacion');
            $table->date('fecha_caducidad');
            $table->string('estado', 20);

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('usuarios')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};
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
    Schema::create('administradores', function (Blueprint $t) {
        $t->id('id_administrador');
        $t->string('nombre', 100);
        $t->string('correo', 150)->unique();
        $t->string('contrasena');
        $t->string('perfil', 50);                  
        $t->boolean('estado')->default(true);      
        $t->string('token_recordar', 100)->nullable();

        // Auditoría
        $t->unsignedBigInteger('creado_por')->nullable();
        $t->unsignedBigInteger('actualizado_por')->nullable();
        $t->timestamp('fecha_creacion')->nullable();
        $t->timestamp('fecha_actualizacion')->nullable();
        $t->timestamp('fecha_eliminacion')->nullable();
    });
}

public function down(): void
{
    Schema::dropIfExists('administradores');
}

};

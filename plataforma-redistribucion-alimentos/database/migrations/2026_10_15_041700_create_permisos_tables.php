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
    Schema::create('permisos', function (Blueprint $t) {
        $t->id();
        $t->string('clave', 50)->unique();
        $t->string('descripcion', 150)->nullable();
    });

    Schema::create('administrador_permiso', function (Blueprint $t) {
        $t->foreignId('id_administrador')->constrained('administradores', 'id_administrador')->cascadeOnDelete();
        $t->foreignId('permiso_id')->constrained('permisos')->cascadeOnDelete();
        $t->primary(['id_administrador', 'permiso_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('administrador_permiso');
    Schema::dropIfExists('permisos');
}

};

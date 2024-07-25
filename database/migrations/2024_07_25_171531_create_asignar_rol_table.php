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
        Schema::create('asignar_rol', function (Blueprint $table) {
            $table->id(); // Crea la columna id con auto incremento
            $table->unsignedBigInteger('id_usuario'); // Columna para almacenar el id del usuario
            $table->string('nombre'); // Columna para el nombre
            $table->string('correo'); // Columna para el correo
            $table->unsignedBigInteger('id_rol'); // Columna para el id del rol
            
            // Definición de claves foráneas
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('restrict');
            
            $table->timestamps(); // Agrega las columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignar_rol');
    }
};

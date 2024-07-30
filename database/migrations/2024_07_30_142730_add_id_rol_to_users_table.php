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
        Schema::table('users', function (Blueprint $table) {
            // Agrega la columna id_rol como una clave foránea
            $table->unsignedBigInteger('id_rol')->nullable()->after('id');
            
            // Define la clave foránea
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Elimina la clave foránea antes de eliminar la columna
            $table->dropForeign(['id_rol']);
            
            // Luego elimina la columna
            $table->dropColumn('id_rol');
        });
    }
};

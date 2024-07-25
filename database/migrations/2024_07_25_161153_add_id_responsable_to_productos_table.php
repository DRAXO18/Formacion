<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->unsignedBigInteger('id_responsable')->nullable(); // Asegúrate de que la columna coincida con el tipo de datos adecuado
    });
}

public function down()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->dropColumn('id_responsable');
    });
}

};

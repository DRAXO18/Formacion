<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tienda', function (Blueprint $table) {
            $table->id(); // Esto crea un campo unsignedBigInteger llamado "id" y es auto incrementable
            $table->string('nombre_tienda');
            $table->string('direccion');
            $table->unsignedBigInteger('id_ubigeo')->nullable(); // Sin valor predeterminado
            $table->foreign('id_ubigeo')->references('id')->on('ubigeo')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tienda');
    }
}

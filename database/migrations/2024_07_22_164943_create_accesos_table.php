<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesosTable extends Migration
{
    public function up()
    {
        Schema::create('accesos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('controlador');
            $table->enum('tipo', ['acceso', 'subacceso', 'opcion']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accesos');
    }
}

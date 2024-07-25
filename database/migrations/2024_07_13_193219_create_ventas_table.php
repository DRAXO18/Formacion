<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tipo_venta');
            $table->unsignedBigInteger('cliente_id'); // ID del cliente
            $table->unsignedBigInteger('id_usuario'); // ID del usuario logueado
            $table->date('fecha_venta');
            $table->decimal('total', 8, 2);
            $table->timestamps();

            // Relaciones
            $table->foreign('id_tipo_venta')->references('id')->on('tipo_venta')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}

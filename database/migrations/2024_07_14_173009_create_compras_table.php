<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tipo_compra')->constrained('tipo_venta'); // Foreign key to tipo_venta table for type of purchase
            $table->foreignId('proveedor_id')->constrained('users'); // Foreign key to users table for provider
            $table->foreignId('id_usuario')->constrained('users'); // Foreign key to users table for user who made the purchase
            $table->date('fecha_compra');
            $table->decimal('total', 10, 2);
            // Otros campos relevantes para la compra
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
}


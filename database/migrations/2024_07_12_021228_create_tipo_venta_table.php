<?php

// database/migrations/xxxx_xx_xx_create_tipo_venta_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoVentaTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_venta', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_venta');
    }
}


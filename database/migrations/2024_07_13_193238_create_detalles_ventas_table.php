<?php

// database/migrations/xxxx_xx_xx_create_detalles_ventas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesVentasTable extends Migration
{
    public function up()
    {
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_venta')->constrained('ventas');
            $table->foreignId('id_producto')->constrained('productos');
            $table->decimal('subtotal', 10, 2); // Usamos subtotal en lugar de monto_total_producto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_ventas');
    }
}
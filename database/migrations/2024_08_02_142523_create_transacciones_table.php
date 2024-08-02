<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionesTable extends Migration
{
    public function up()
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billetera_id')->constrained('billeteras')->onDelete('cascade');
            $table->string('tipo'); // 'deposito', 'retiro', 'prestamo', 'pago'
            $table->decimal('monto', 15, 2);
            $table->string('descripcion')->nullable();
            $table->date('fecha')->default(now());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transacciones');
    }
}

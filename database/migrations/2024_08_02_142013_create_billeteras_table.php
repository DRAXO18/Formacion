<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBilleterasTable extends Migration
{
    public function up()
    {
        Schema::create('billeteras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('saldo', 15, 2)->default(0.00); // Saldo disponible
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billeteras');
    }
}

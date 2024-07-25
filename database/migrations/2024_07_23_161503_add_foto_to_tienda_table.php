<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoToTiendaTable extends Migration
{
    public function up()
    {
        Schema::table('tienda', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('direccion');
        });
    }

    public function down()
    {
        Schema::table('tienda', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
}

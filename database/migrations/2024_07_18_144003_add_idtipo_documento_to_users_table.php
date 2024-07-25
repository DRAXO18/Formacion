<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdtipoDocumentoToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('idtipo_documento')->nullable();
            $table->foreign('idtipo_documento')->references('id')->on('tipo_documento');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['idtipo_documento']);
            $table->dropColumn('idtipo_documento');
        });
    }
}

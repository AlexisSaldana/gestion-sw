<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaCodigoTable extends Migration
{
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->string('codigo')->nullable()->after('estado');
        });
    }

    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn('codigo');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas');
            $table->foreignId('usuariomedicoid')->constrained('users');
            $table->text('diagnostico');
            $table->text('receta')->nullable();
            $table->decimal('total_pagar', 8, 2);
            $table->enum('estado', ['En proceso', 'Finalizado']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}

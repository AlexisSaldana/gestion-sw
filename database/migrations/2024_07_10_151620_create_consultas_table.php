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
            $table->foreignId('enfermera_id')->nullable()->constrained('users');
            $table->decimal('total_pagar', 8, 2);
            $table->enum('estado', ['En proceso', 'Finalizado']);
            $table->string('motivo', 1000)->nullable();
            $table->string('talla', 1000)->nullable();
            $table->string('temperatura', 1000)->nullable();
            $table->string('saturacion_oxigeno', 1000)->nullable();
            $table->string('frecuencia_cardiaca', 1000)->nullable();
            $table->string('peso', 1000)->nullable();
            $table->string('tension_arterial', 1000)->nullable();
            $table->string('padecimiento', 1000)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}

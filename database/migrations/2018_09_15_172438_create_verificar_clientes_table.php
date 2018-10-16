<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificarClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificar_clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('cliente_cpf');
            $table->string('token');
            $table->timestamps();
            $table->foreign('cliente_cpf')
            ->references('cpf')->on('clientes')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verificar_clientes');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransacaoTable extends Migration
{
    public function up()
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('transacao_id')->unique();
            $table->integer('conta_id')->unsigned();
            $table->string('nome_transacao');
            $table->double('valor_transacao');
            $table->timestamp('data_transacao');

            $table->integer('transacable_id');
            $table->string('transacable_type');

            $table->foreign('conta_id')
            ->references('conta_id')->on('contas')
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
        Schema::dropIfExists('contas');
    }
}

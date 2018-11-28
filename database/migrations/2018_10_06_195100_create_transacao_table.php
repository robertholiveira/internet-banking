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
            $table->increments('transacao_id',10)->unique();
            $table->integer('conta_id',10)->unsigned();
            $table->string('nome_transacao',100);
            $table->double('valor_transacao', 9, 2);
            $table->timestamp('data_transacao');
            $table->string('tipo_transacao',45);

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
        Schema::dropIfExists('transacoes');
    }
}

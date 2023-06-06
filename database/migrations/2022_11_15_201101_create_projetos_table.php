<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Enum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->string('num_contrato');
            $table->string('nome');

            $table->unsignedBigInteger('fundacao_id');
            $table->foreign('fundacao_id')->references('id')->on('fundacoes');

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->dateTime('data_termino')->nullable();

            $table->unsignedBigInteger('tipo_projetos_id');
            $table->foreign('tipo_projetos_id')->references('id')->on('tipo_projetos');

            //Valores
            $table->decimal('valor_contrato');
            $table->decimal('valor_aditivos')->default(0);
            $table->decimal('valor_recebido')->default(0);
            $table->decimal('valor_receber');
            $table->decimal('valor_gasto');
            /**
             * Status do Projeto
             * 0 - Não Iniciado
             * 1 - Em Andamento
             * 2 - Atrazado
             * 3 - Finalizado
             */

            $table->enum('status', [0, 1, 2, 3])->default(0);
            $table->decimal('porc_conclusao')->nullable(); // Porcentagem
            $table->boolean('prazo')->default(1); // 1 = Sim, 0 = Não
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projetos');
    }
};

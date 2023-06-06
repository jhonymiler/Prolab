<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ativos', function (Blueprint $table) {
            $table->id();
            $table->string("equipamento");
            $table->string("modelo")->nullable();
            $table->string("fabricante")->nullable();
            $table->string("ano")->nullable();
            $table->string('moeda')->nullable('BRL');
            $table->string('sigla')->nullable('R$');

            $table->decimal("valor", 18, 2)->nullable('0.00');
            $table->decimal("valor_convertido", 18, 2)->nullable();
            $table->string("vida_util")->nullable(); //anos
            $table->decimal("potencia", 18, 2)->nullable(); //watts
            $table->string("horas")->nullable(); //hrs / dia de funcionamento
            $table->string("dias")->nullable();
            $table->string("custo_manutencao", 18, 2)->nullable(); //custos de manutenção
            $table->string("custo_pecas", 18, 2)->nullable(); //custo de peças de reposição
            $table->boolean("afericao")->nullable();
            $table->decimal("depreciacao", 18, 2)->nullable();
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
        Schema::dropIfExists('ativos');
    }
};

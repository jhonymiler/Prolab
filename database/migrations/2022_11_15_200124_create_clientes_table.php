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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('cnpj');
            $table->string('telefone');
            $table->string('celular')->nullable();
            $table->string('email');
            $table->string('responsavel');
            $table->string('ie')->nullable();
            $table->string('cep');
            $table->string('rua');
            $table->string('complemento')->nullable();
            $table->string('num');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('uf');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('clientes');
    }
};

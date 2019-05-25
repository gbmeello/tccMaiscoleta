<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function($table, $callback) {
            return new CustomBlueprint($table, $callback);
        });

        $schema->create('fornecedor', function (Blueprint $table) {
            $table->increments('pk_fornecedor')->comment('Chave primária e única da tabela Ponto_Coleta');
            $table->unsignedInteger('fk_estado')->nullable()->comment('Estado onde o fornecedor reside');
            $table->unsignedInteger('fk_municipio')->nullable()->comment('Municpio onde o fornecedor reside');
            $table->string('nome_fantasia', 200)->comment('Nome fantasia do fornecedor');
            $table->string('razao_social', 300)->comment('Razão Social do fornecedor');
            $table->string('email', 100)->comment('Email do fornecedor');
            $table->char('telefone1', 15)->nullable()->comment('Telefone 1 do fornecedor');
            $table->char('telefone2', 15)->nullable()->comment('Telefone 2 do fornecedor');
            $table->char('cep', 8)->nullable()->comment('CEP de onde o fornecedor reside');
            $table->string('bairro', 150)->nullable()->comment('Bairro de onde o fornecedor reside');
            $table->string('rua', 150)->nullable()->comment('Rua de onde o fornecedor reside');
            $table->string('logradouro', 200)->nullable()->comment('Logradouro de onde o fornecedor reside');
            $table->string('complemento', 300)->nullable()->comment('Complemento onde o fornecedor reside');
            $table->customTimestamps();
            $table->boolean('ativo')->default(true)->comment('Status que se encontra atualmente o registro: ativo(true), inativo(false)');

            $table->foreign('fk_estado')->references('pk_estado')->on('estado')->onDelete('cascade');
            $table->foreign('fk_municipio')->references('pk_municipio')->on('municipio')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedor');
    }
}

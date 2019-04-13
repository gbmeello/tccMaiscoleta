<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteFinalTable extends Migration
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

        $schema->create('cliente_final', function (Blueprint $table) {
            $table->increments('pk_cliente_final')->comment('Chave primária e única da Tabela Cliente_Final');
            $table->string('nome_fantasia', 200)->comment('Nome fantasia do cliente final');
            $table->string('razao_social', 300)->comment('Razão Social do cliente final');
            $table->string('email', 100)->comment('Email do cliente final');
            $table->char('telefone1', 15)->comment('Telefone 1 do cliente final');
            $table->char('telefone2', 15)->nullable()->comment('Telefone 2 do cliente final');
            $table->string('cidade', 150)->comment('Cidade onde o cliente final reside');
            $table->string('estado', 50)->comment('Estado onde o cliente final reside');
            $table->char('cep', 8)->nullable()->comment('CEP de onde o cliente final reside');
            $table->string('bairro', 150)->nullable()->comment('Bairro de onde o cliente final reside');
            $table->string('rua', 150)->nullable()->comment('Rua de onde o cliente final reside');
            $table->string('logradouro', 200)->nullable()->comment('Logradouro de onde o cliente final reside');
            $table->string('complemento', 300)->nullable()->comment('Complemento onde o cliente final reside');
            $table->customTimestamps();
            $table->boolean('ativo')->default(true)->comment('Status que se encontra atualmente o registro: ativo(true), inativo(false)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_final');
    }
}

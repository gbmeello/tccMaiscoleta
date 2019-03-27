<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteDestinoTable extends Migration
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

        //TODO comentar as colunas e validar a estrutura do banco
        $schema->create('cliente_destino', function (Blueprint $table) {
            $table->increments('pk_cliente_destino')->comment('Chave primária e única da Tabela Cliente Destino');
            $table->string('nome_fantasia', 200)->comment('Nome fantasia do cliente destino');
            $table->string('razao_social', 300)->comment('Razão Social do cliente destino');
            $table->string('email', 100)->comment('Email do cliente destino');
            $table->char('telefone1', 15)->comment('Telefone 1 do cliente destino');
            $table->char('telefone2', 15)->comment('Telefone 2 do cliente destino');
            $table->string('cidade', 150)->comment('Cidade onde o cliente destino reside');
            $table->string('estado', 50)->comment('Estado onde o cliente destino reside');
            $table->char('cep', 8)->comment('CEP de onde o cliente destino reside');
            $table->string('bairro', 150)->comment('Bairro de onde o cliente destino reside');
            $table->string('rua', 150)->comment('Rua de onde o cliente destino reside');
            $table->string('logradouro', 200)->comment('Logradouro de onde o cliente destino reside');
            $table->string('complemento', 300)->comment('Complemento onde o cliente destino reside');
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status do cliente: ativo(1), inativo(2) ou excluído(3)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_destino');
    }
}

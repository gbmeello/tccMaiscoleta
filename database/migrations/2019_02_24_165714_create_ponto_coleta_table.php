<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePontoColetaTable extends Migration
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

        $schema->create('ponto_coleta', function (Blueprint $table) {
            $table->bigIncrements('pk_ponto_coleta')->comment('Chave primária e única da tabela Ponto_Coleta');
            $table->string('nome', 100)->unique()->comment('Nome do ponto de coleta');
            $table->decimal('latitude', 20, 16)->comment('Latitude do ponto de coleta');
            $table->decimal('longitude', 20, 16)->comment('Longitude do ponto de coleta');
            $table->string('descricao', 300)->nullable()->comment('Descrição do ponto de coleta');
            $table->timestamps();
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
        Schema::dropIfExists('ponto_coleta');
    }
}

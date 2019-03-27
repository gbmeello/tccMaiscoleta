<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRotaTable extends Migration
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

        $schema->create('rota', function (Blueprint $table) {
            $table->increments('pk_rota')->comment('Chave primária e única da tabela rotas');
            $table->string('nome', 100)->comment('Nome da rota');
            $table->string('observacao', 500)->comment('Observação da rota');
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status que se encontra atualmente a rota: ativo(1), inativo(2) ou excluido(3)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rota');
    }
}

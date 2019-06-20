<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRotaFinalTable extends Migration
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

        $schema->create('rota_final', function (Blueprint $table) {
            $table->bigIncrements('pk_rota_final')->comment('Chave primária, única e incremental da tabela Rota_Final');
            $table->unsignedBigInteger('fk_rota')->comment('Chave estrangira em uma relação de n para n, vinda da tabela Rota');
            $table->unsignedBigInteger('fk_ponto_coleta')->comment('Chave estrangeira em uma relação de n para n, vinda da tabela Ponto_Coleta');
            $table->customTimestamps();
            $table->boolean('ativo')->default(true)->comment('Status que se encontra atualmente o registro: ativo(true), inativo(false)');

            $table->foreign('fk_ponto_coleta')
                ->references('pk_ponto_coleta')
                ->on('ponto_coleta')
                ->onDelete('cascade');

            $table->foreign('fk_rota')
                ->references('pk_rota')
                ->on('rota')
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
        Schema::dropIfExists('rota_final');
    }
}

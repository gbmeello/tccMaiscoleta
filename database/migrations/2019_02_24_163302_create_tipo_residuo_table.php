<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoResiduoTable extends Migration
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

        $schema->create('tipo_residuo', function (Blueprint $table) {
            $table->bigIncrements('pk_tipo_residuo')->comment('Chave primária e única da tabela Tipo_Residuo');
            $table->string('nome', 100)->unique()->comment('Nome do tipo de resíduo');
            $table->string('descricao', 600)->nullable()->comment('Descrição do tipo de resíduo');
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
        Schema::dropIfExists('tipo_residuo');
    }
}

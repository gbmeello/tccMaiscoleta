<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriagemTable extends Migration
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

        $schema->create('triagem', function (Blueprint $table) {
            $table->bigIncrements('pk_triagem')->comment('Chave primária e única da tabela Triagem');
            $table->unsignedBigInteger('fk_coleta')->comment('Chave estrangeira vinda da tabela Coleta');
            $table->unsignedBigInteger('fk_tipo_residuo')->comment('Chave estrangeira vinda da tabela Tipo_Residuo');
            $table->timestamp('data_triagem')->comment('Data na qual foi feita a triagem');
            $table->double('peso_medio')->comment('Peso separado da triagem');
            $table->string('observacao', 600)->nullable()->comment('Observação da triagem');
            $table->customTimestamps();
            $table->boolean('ativo')->default(true)->comment('Status que se encontra atualmente o registro: ativo(true), inativo(false)');

            $table->foreign('fk_coleta')->references('pk_coleta')->on('coleta')->onDelete('cascade');
            $table->foreign('fk_tipo_residuo')->references('pk_tipo_residuo')->on('tipo_residuo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('triagem');
    }
}

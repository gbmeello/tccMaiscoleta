<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColetaTable extends Migration
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

        $schema->create('coleta', function (Blueprint $table) {
            $table->bigIncrements('pk_coleta')->comment('Chave primária e única da tabela Coleta');
            $table->unsignedBigInteger('fk_rota')->comment('Chave estrangeira vinda da tabela Rota');
            $table->unsignedBigInteger('fk_veiculo')->nullable()->comment('Chave estrangeira vinda da tabela Veiculo');
            $table->unsignedBigInteger('fk_fornecedor')->nullable()->comment('Chave estrangeira vinda da tabela fornecedor');
            $table->timestamp('data_coleta')->nullable()->comment('Data da coleta');
            $table->boolean('has_coleta')->comment('Se teve coleta ou não naquele dia');
            $table->string('observacao', 1000)->nullable()->comment('Observação relacionada a coleta');
            $table->customTimestamps();
            $table->boolean('ativo')->default(true)->comment('Status que se encontra atualmente o registro: ativo(true), inativo(false)');

            $table->foreign('fk_rota')->references('pk_rota')->on('rota')->onDelete('cascade');
            $table->foreign('fk_veiculo')->references('pk_veiculo')->on('veiculo')->onDelete('cascade');
            $table->foreign('fk_fornecedor')->references('pk_fornecedor')->on('fornecedor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coleta');
    }
}

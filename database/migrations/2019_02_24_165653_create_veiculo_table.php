<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeiculoTable extends Migration
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

        $schema->create('veiculo', function (Blueprint $table) {
            $table->increments('pk_veiculo')->comment('Chave primária e unica da tabela Veiculo');
            $table->string('modelo', 100)->comment('Modelo do veículo');
            $table->string('observacao', 300)->nullable()->comment('Observação relacionada ao veículo');
            $table->string('placa', 10)->comment('Placa do veículo');
            $table->string('tipo', 50)->nullable()->comment('Tipo do veículo');
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
        Schema::dropIfExists('veiculo');
    }
}

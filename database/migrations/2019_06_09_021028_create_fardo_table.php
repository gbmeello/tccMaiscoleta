<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFardoTable extends Migration
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

        $schema->create('fardo', function (Blueprint $table) {
            $table->bigIncrements('pk_fardo')->comment('Chave primária e única da tabela Fardo');
            $table->unsignedBigInteger('fk_tipo_residuo')->comment('Chave estrangeira vinda da tabela Tipo_Residuo');
            $table->unsignedBigInteger('fk_cliente_final')->comment('Chave estrangeira vinda da tabela Cliente_Final');
            $table->unsignedBigInteger('fk_triagem')->nullable()->comment('Chave estrangeira vinda da tabela Triagem');
            $table->string('lote')->nullable()->comment('Lote do Fardo');
            $table->timestamp('data_venda')->nullable()->comment('Data da venda do Fardo');
            $table->double('peso')->comment('Peso separado do Fardo');
            $table->enum('unidade_medida', ['g', 'kg', 'ton'])->comment('Unidade de Medida separado do Fardo');
            $table->string('observacao', 1000)->nullable()->comment('Observação do Fardo');
            $table->enum('status', ['estoque', 'vendido'])->default('estoque')->comment('Status do Fardo');
            $table->customTimestamps();
            $table->boolean('ativo')->default(true)->comment('Status que se encontra atualmente o registro: ativo(true), inativo(false)');

            $table->foreign('fk_tipo_residuo')->references('pk_tipo_residuo')->on('tipo_residuo')->onDelete('cascade');
            $table->foreign('fk_cliente_final')->references('pk_cliente_final')->on('cliente_final')->onDelete('cascade');
            $table->foreign('fk_triagem')->references('pk_triagem')->on('triagem')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fardo');
    }
}

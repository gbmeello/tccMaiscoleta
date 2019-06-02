<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipioTable extends Migration
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

        $schema->create('municipio', function (Blueprint $table) {
            $table->increments('pk_municipio');
            $table->integer('fk_estado')->unsigned();
            $table->string('nome');
            $table->integer('cod_ibge');
            $table->integer('ddd')->nullable();
            $table->integer('status')->nullable();
            $table->string('slug')->nullable();
            $table->integer('populacao')->nullable();
            $table->decimal('latitude', 12, 8)->nullable();
            $table->decimal('longitude', 12, 8)->nullable();
            $table->decimal('renda_per_capita', 8, 2)->nullable();
            $table->customTimestamps();

            $table->foreign('fk_estado')->references('pk_estado')->on('estado')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipio');
    }
}

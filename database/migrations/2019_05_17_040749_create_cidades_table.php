<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidades', function (Blueprint $table) {
            $table->increments('pk_cidade');
            $table->integer('fk_estado')->unsigned();
            $table->string('nome');
            $table->integer('cod_ibge');
            $table->integer('ddd');
            $table->integer('status');
            $table->string('slug');
            $table->integer('populacao');
            $table->decimal('latitude', 12, 8);
            $table->decimal('longitude', 12, 8);
            $table->decimal('renda_per_capita', 8, 2);
            $table->timestamps();

            $table->foreign('fk_estado')->references('pk_estado')->on('estados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cidades');
    }
}

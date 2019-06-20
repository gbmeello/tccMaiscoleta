<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFardoColumnLote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fardo', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_triagem')->nullable()->comment('Chave estrangeira vinda da tabela Triagem')->change();
            $table->string('lote')->nullable()->comment('Lote do Fardo')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

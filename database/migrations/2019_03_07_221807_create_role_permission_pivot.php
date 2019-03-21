<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->increments('pk_role_permission');

            $table->integer('pk_role');
            $table->foreign('pk_role')
                ->references('pk_role')
                ->on('roles')
                ->onDelete('cascade');

            $table->integer('pk_permission');
            $table->foreign('pk_permission')
                ->references('pk_permission')
                ->on('permissions')
                ->onDelete('cascade');

            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status da permissao: ativo(1), inativo(2) ou excluido(3)');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permission');
    }
}

<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
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
        $schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function($table, $callback) {
            return new CustomBlueprint($table, $callback);
        });

        $schema->create('role_permission_pivot', function (Blueprint $table) {
            $table->increments('pk_role_permission')->comment('Chave primária incremental e única da tabela');
            $table->unsignedInteger('fk_role')->comment('Chave estrangeira vinda da tabela Role');
            $table->unsignedInteger('fk_permission')->comment('Chave estrangeira vinda da tabela Permissions');
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status da permissao: ativo(1), inativo(2) ou excluido(3)');

            $table->foreign('fk_role')
                ->references('pk_role')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('fk_permission')
                ->references('pk_permission')
                ->on('permissions')
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
        Schema::dropIfExists('role_permission_pivot');
    }
}

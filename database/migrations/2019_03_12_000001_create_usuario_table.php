<?php

use App\Extendz\CustomBlueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration
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

        $schema->create('usuario', function (Blueprint $table) {
            $table->increments('pk_usuario');
            $table->unsignedInteger('fk_role');
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('senha');
            $table->rememberToken();
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status do usuario: ativo(1), inativo(2) ou excluido(3)');

            $table->foreign('fk_role')
                ->references('pk_role')
                ->on('roles')
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
        //Schema::dropIfExists('role_permission_pivot');
        //Schema::dropIfExists('roles');
        Schema::dropIfExists('usuario');
    }
}

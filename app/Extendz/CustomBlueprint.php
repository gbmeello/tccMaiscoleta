<?php

namespace App\Extendz;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CustomBlueprint extends Blueprint {

    public function customTimestamps() {
        $this->timestamp('data_criacao', 0)->useCurrent()->comment('Data de criação do registro');
        $this->timestamp('data_atualizacao', 0)->nullable()->comment('Data de atualização do registro');
    }
}
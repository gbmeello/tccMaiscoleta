<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PontoColeta extends Model
{
    public function rotas() {
        return $this->belongsToMany('App\Rota', 'rota_final', 'pk_rota', 'pk_ponto_coleta');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PontoColeta extends Model
{
    protected $table = 'ponto_coleta';
    protected $primaryKey = 'pk_ponto_coleta';
    protected $fillable = [
        'nome', 'latitude', 'longitude', 'descricao', 'ativo'
    ];

    public function rotas() {
        return $this->belongsToMany('App\Rota', 'rota_final', 'pk_rota', 'pk_ponto_coleta');
    }
}

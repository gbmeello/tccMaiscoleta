<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PontoColeta extends BaseModel
{
    protected $table = 'ponto_coleta';
    protected $primaryKey = 'pk_ponto_coleta';
    protected $fillable = [
        'nome', 'latitude', 'longitude', 'descricao', 'ativo'
    ];
    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function rotas() {
        return $this->belongsToMany(Rota::class, 'rota_final', 'fk_ponto_coleta', 'fk_rota');
    }
}

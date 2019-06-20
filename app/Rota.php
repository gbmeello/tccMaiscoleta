<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rota extends BaseModel
{
    protected $table = 'rota';
    protected $primaryKey = 'pk_rota';

    protected $fillable = [
        'pk_rota', 'nome', 'observacao', 'ativo'
    ];

    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function pontosColeta() {
        return $this->belongsToMany(PontoColeta::class, 'rota_final', 'fk_rota', 'fk_ponto_coleta');
    }
}

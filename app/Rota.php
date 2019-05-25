<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rota extends Model
{
    protected $table = 'rota';
    protected $primaryKey = 'pk_rota';

    protected $fillable = [
        'pk_rota', 'nome', 'observacao', 'ativo'
    ];

    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function pontosColeta() {
        return $this->belongsToMany(PontoColeta::class, 'rota_final', 'pk_ponto_coleta', 'pk_rota');
    }
}

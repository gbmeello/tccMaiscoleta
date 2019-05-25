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

    public $timestamps = false;

    public function rotas() {
        return $this->belongsToMany(Rota::class, 'rota_final', 'pk_rota', 'pk_ponto_coleta');
    }
}

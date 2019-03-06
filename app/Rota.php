<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rota extends Model
{
    protected $table = 'rota';
    protected $primaryKey = 'pk_rota';
    protected $fillable = ['pk_rota', 'nome', 'observacao', 'status'];

    public function pontosColetas() {
        return $this->belongsToMany('App\PontoColeta', 'rota_final', 'pk_ponto_coleta', 'pk_rota');
    }
}

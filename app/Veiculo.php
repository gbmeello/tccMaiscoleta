<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends BaseModel
{
    protected $primaryKey = 'pk_veiculo';
    protected $table = 'veiculo';
    protected $fillable = [
        'modelo', 'observacao', 'placa', 'ativo'
    ];

    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function coletas() {
        return $this->hasMany(Coleta::class, 'fk_veiculo');
    }
}

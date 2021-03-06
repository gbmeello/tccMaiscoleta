<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoResiduo extends BaseModel
{
    protected $primaryKey = 'pk_tipo_residuo';
    protected $table = 'tipo_residuo';
    protected $fillable = [
        'nome', 'descricao', 'ativo'
    ];
    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function triagens() {
        return $this->hasMany(Triagem::class, 'fk_tipo_residuo');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Residuo extends Model
{
    protected $primaryKey = 'pk_residuo';
    protected $table = 'residuo';
    protected $fillable = [
        'pk_residuo', 'nome', 'descricao', 'ativo'
    ];
    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function tipoResiduo() {
        $this->hasOne(TipoResiduo::class, 'pk_tipo_residuo');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Residuo extends Model
{
    protected $primaryKey = 'pk_residuo';
    protected $table = 'residuo';
    protected $fillable = [
        'nome', 'descricao', 'ativo'
    ];
    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function tipoResiduo() {
        return $this->belongsTo(TipoResiduo::class, 'pk_tipo_residuo', 'fk_tipo_residuo');
    }

    public function triagens() {
        $this->hasMany(Triagem::class, 'fk_residuo');
    }
}

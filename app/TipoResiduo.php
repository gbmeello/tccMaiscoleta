<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoResiduo extends Model
{
    protected $primaryKey = 'pk_tipo_residuo';
    protected $table = 'tipo_residuo';
    protected $fillable = [
      'pk_tipo_residuo', 'nome', 'descricao', 'ativo'
    ];
    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function residuos() {
        $this->belongsTo(Residuo::class, 'pk_residuo');
    }
}

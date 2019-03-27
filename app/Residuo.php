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

    public function residuos() {
        $this->belongsTo(Residuo::class, 'pk_residuo');
    }
}

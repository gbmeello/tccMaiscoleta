<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $primaryKey = 'pk_veiculo';
    protected $table = 'veiculo';
    protected $fillable = [
        'pk_veiculo', 'modelo', 'observacao', 'placa', 'status'
    ];
    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;
}

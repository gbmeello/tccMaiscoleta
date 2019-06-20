<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends BaseModel
{
    protected $primaryKey = "pk_municipio";
    protected $table = "municipio";
    protected $fillable = [
        'fk_estado', 'nome', 'cod_ibge', 'ddd', 'status', 'slug', 'populacao',
        'latitude', 'longitude', 'renda_per_capita'
    ];

    public $timestamps = false;

    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public function estado() {
        return $this->belongsTo(Estado::class, 'fk_estado', 'pk_estado');
    }
}

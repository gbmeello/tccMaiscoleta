<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $primaryKey = "pk_estado";
    protected $table = "estado";
    protected $fillable = [
        'nome', 'sigla', 'cod_ibge', 'slug', 'populacao'
    ];
    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function municipios() {
        return $this->hasMany(Municipio::class, 'fk_estado');
    }

}

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

    public $timestamps = false;

    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public function municipios() {
        return $this->hasMany(Municipio::class, 'pk_municipio');
    }

}

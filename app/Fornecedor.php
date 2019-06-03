<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $primaryKey = "pk_fornecedor";
    protected $table = "fornecedor";
    protected $fillable = [
        'fk_municipio', 'nome_fantasia', 'razao_social', 'email',
        'telefone1', 'telefone2', 'cep', 'bairro', 'rua', 'logradouro', 'complemento', 'ativo'
    ];

    public $timestamps = false;

    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public function setMunicipioAttribute($value) {
        $this->attributes['fk_municipio'] = $value;
    }

    public function coletas() {
        $this->hasMany(Coleta::class, 'fk_fornecedor');
    }

    public function municipio() {
        return $this->belongsTo(Municipio::class, 'fk_municipio', 'pk_municipio');
    }

}

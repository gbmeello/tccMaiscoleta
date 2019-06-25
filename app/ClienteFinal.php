<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteFinal extends BaseModel
{
    protected $primaryKey = "pk_cliente_final";
    protected $table = "cliente_final";
    protected $fillable = [
        'fk_municipio', 'nome_fantasia', 'razao_social', 'email',
        'telefone1', 'telefone2', 'cep', 'bairro', 'rua', 'logradouro', 'complemento', 'ativo'
    ];
    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function setMunicipioAttribute($value) {
        $this->attributes['fk_municipio'] = $value;
    }

    public function municipio() {
        return $this->belongsTo(Municipio::class, 'fk_municipio', 'pk_municipio');
    }

    public function fardos() {
        return $this->hasMany(Fardo::class, 'fk_cliente_final');
    }
}

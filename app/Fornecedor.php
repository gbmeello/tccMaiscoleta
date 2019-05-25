<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $primaryKey = "pk_fornecedor";
    protected $table = "fornecedor";
    protected $fillable = [
        'fk_estado', 'fk_municipio', 'nome_fantasia', 'razao_social', 'email',
        'telefone1', 'telefone2', 'cep', 'bairro', 'rua', 'logradouro', 'complemento', 'ativo'
    ];

    public $timestamps = false;

    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public function coleta() {
        $this->belongsTo(Coleta::class, 'pk_coleta');
    }

    public function municipio() {
        return $this->belongsTo(Municipio::class, 'fk_municipio', 'pk_municipio');
    }

    public function estado() {
        return $this->belongsTo(Estado::class, 'fk_estado', 'pk_estado');
    }

}

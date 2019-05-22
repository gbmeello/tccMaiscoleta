<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $primaryKey = "pk_fornecedor";
    protected $table = "fornecedor";
    protected $fillable = [
        'pk_fornecedor', 'nome_fantasia', 'razao_social', 'email', 'telefone1', 'telefone2',
        'cidade', 'estado', 'cep', 'bairro', 'rua', 'logradouro', 'complemento', 'ativo'
    ];

    public $timestamps = false;

    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public function coleta() {
        $this->belongsTo(Coleta::class, 'pk_coleta');
    }

}

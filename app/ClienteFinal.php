<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteFinal extends Model
{
    protected $primaryKey = "pk_cliente_final";
    protected $table = "cliente_final";
    protected $fillable = [
        'nome_fantasia', 'razao_social', 'email', 'telefone1', 'telefone2',
        'cidade', 'estado', 'cep', 'bairro', 'rua', 'logradouro', 'complemento', 'ativo'
    ];

    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function triagem() {
        $this->belongsTo(Triagem::class, 'pk_triagem');
    }
}

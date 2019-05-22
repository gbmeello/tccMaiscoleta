<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coleta extends Model
{
    protected $primaryKey = "pk_coleta";
    protected $table = "coleta";
    protected $fillable = [
        'fk_ponto_coleta', 'fk_veiculo', 'fk_fornecedor', 'data_coleta', 'has_coleta',
        'observacao', 'ativo'
    ];

    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function rotaFinal() {
        $this->hasOne(RotaFinal::class, 'pk_rota_final');
    }

    public function veiculo() {
        $this->hasOne(Veiculo::class, 'pk_veiculo');
    }

    public function fornecedor() {
        $this->hasOne(Fornecedor::class, 'pk_fornecedor');
    }
}

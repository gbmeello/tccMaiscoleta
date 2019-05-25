<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coleta extends Model
{
    protected $primaryKey = "pk_coleta";
    protected $table = "coleta";
    protected $fillable = [
        'fk_rota_final', 'fk_veiculo', 'fk_fornecedor', 'data_coleta', 'has_coleta',
        'observacao', 'ativo'
    ];

    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function rotaFinal() {
        $this->belongsTo(RotaFinal::class, 'fk_rota_final', 'pk_rota_final');
    }

    public function veiculo() {
        $this->belongsTo(Veiculo::class, 'fk_veiculo', 'pk_veiculo');
    }

    public function fornecedor() {
        $this->belongsTo(Fornecedor::class, 'fk_fornecedor', 'pk_fornecedor');
    }
}

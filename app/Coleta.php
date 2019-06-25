<?php

namespace App;

use Carbon\Carbon;

class Coleta extends BaseModel
{
    protected $primaryKey = "pk_coleta";
    protected $table = "coleta";
    protected $fillable = [
        'fk_rota', 'fk_veiculo', 'fk_fornecedor', 'data_coleta',
        'observacao', 'ativo'
    ];
    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

//    protected $dates = ['data_coleta'];

    public $timestamps = false;

    public function getDataColetaAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function setDataColetaAttribute($value) {
        $this->attributes['data_coleta'] = Carbon::createFromFormat('Y-m-d', $value);
    }

    public function setFornecedorAttribute($value) {
        $this->attributes['fk_fornecedor'] = $value;
    }

    public function setVeiculoAttribute($value) {
        $this->attributes['fk_veiculo'] = $value;
    }

    public function setRotaAttribute($value) {
        $this->attributes['fk_rota'] = $value;
    }

    public function veiculo() {
        return $this->belongsTo(Veiculo::class, 'fk_veiculo', 'pk_veiculo');
    }

    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class, 'fk_fornecedor', 'pk_fornecedor');
    }

    public function rotas() {
        return $this->belongsTo(Rota::class, 'fk_rota', 'pk_rota');
    }
}

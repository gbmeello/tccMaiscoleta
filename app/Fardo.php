<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Fardo extends BaseModel
{
    /**
     * Unidades de Medida ENUM
     */
    public const UNIDADES_MEDIDA = [
        'g' => 'g',
        'kg' => 'kg',
        'ton' => 'ton'
    ];

    /**
     * Status ENUM
     */
    public const STATUS = [
        'estoque' => 'Estoque',
        'vendido' => 'Vendido',
    ];

    protected $primaryKey = "pk_fardo";
    protected $table = "fardo";
    protected $fillable = [
        'fk_tipo_residuo', 'fk_cliente_final', 'fk_triagem', 'status',
        'lote', 'data_venda', 'peso', 'unidade_medida', 'observacao', 'ativo'
    ];

    public $timestamps = false;

    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];
    
    public function getDataVendaAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function setUnidadeMedidaAttribute($value) {
        $this->attributes['unidade_medida'] = $value;
    }

    public function setStatusAttribute($value) {
        $this->attributes['status'] = $value;
    }

    public function setTipoResiduoAttribute($value) {
        $this->attributes['fk_tipo_residuo'] = $value;
    }

    public function setClienteFinalAttribute($value) {
        $this->attributes['fk_cliente_final'] = $value;
    }

    public function setTriagemAttribute($value) {
        $this->attributes['fk_triagem'] = $value;
    }

    public function tipoResiduo() {
        return $this->belongsTo(TipoResiduo::class, 'fk_tipo_residuo', 'pk_tipo_residuo');
    }

    public function clienteFinal() {
        return $this->belongsTo(ClienteFinal::class, 'fk_cliente_final', 'pk_cliente_final');
    }

    public function triagem() {
        return $this->belongsTo(Triagem::class, 'fk_triagem', 'pk_triagem');
    }
}

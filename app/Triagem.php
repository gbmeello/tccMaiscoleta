<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Triagem extends BaseModel
{
    protected $primaryKey = "pk_triagem";
    protected $table = "triagem";
    protected $fillable = [
        'fk_coleta', 'fk_cliente_final', 'fk_residuo',
        'data_triagem', 'data_venda', 'observacao', 'ativo'
    ];

    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function setColetaAttribute($value) {
        $this->attributes['fk_coleta'] = $value;
    }

    public function setResiduoAttribute($value) {
        $this->attributes['fk_residuo'] = $value;
    }

    public function setClienteFinalAttribute($value) {
        $this->attributes['fk_cliente_final'] = $value;
    }

    public function coleta() {
        return $this->belongsTo(Coleta::class, 'fk_coleta', 'pk_coleta');
    }

    public function clienteFinal() {
        return $this->belongsTo(ClienteFinal::class, 'fk_cliente_final', 'pk_cliente_final');
    }

    public function tipoResiduo() {
        return $this->belongsTo(TipoResiduo::class, 'fk_tipo_residuo', 'pk_tipo_residuo');
    }
}

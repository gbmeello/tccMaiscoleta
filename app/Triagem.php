<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Triagem extends BaseModel
{
    protected $primaryKey = "pk_triagem";
    protected $table = "triagem";
    protected $fillable = [
        'fk_coleta', 'data_triagem', 'observacao', 'ativo'
    ];

    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function setColetaAttribute($value) {
        $this->attributes['fk_coleta'] = $value;
    }

    public function coleta() {
        return $this->belongsTo(Coleta::class, 'fk_coleta', 'pk_coleta');
    }

    // public function tipoResiduo() {
    //     return $this->belongsTo(TipoResiduo::class, 'fk_tipo_residuo', 'pk_tipo_residuo');
    // }
}

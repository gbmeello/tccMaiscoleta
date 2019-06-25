<?php

namespace App;

use Carbon\Carbon;

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
    
    public function getDataTriagemAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function setColetaAttribute($value) {
        $this->attributes['fk_coleta'] = $value;
    }

    public function coleta() {
        return $this->belongsTo(Coleta::class, 'fk_coleta', 'pk_coleta');
    }
    
    public function fardos() {
        return $this->hasMany(Fardo::class, 'fk_triagem');
    }

}

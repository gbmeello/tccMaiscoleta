<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Triagem extends Model
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

    public function coleta() {
        $this->belongsTo(Coleta::class, 'fk_coleta', 'pk_coleta');
    }

    public function clienteFinal() {
        $this->belongsTo(ClienteFinal::class, 'fk_cliente_final', 'pk_cliente_final');
    }

    public function tipoResiduo() {
        $this->belongsTo(TipoResiduo::class, 'fk_tipo_residuo', 'pk_tipo_residuo');
    }
}

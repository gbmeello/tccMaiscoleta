<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Triagem extends Model
{
    protected $primaryKey = "pk_triagem";
    protected $table = "triagem";
    protected $fillable = [
        'pk_triagem', 'fk_coleta', 'fk_cliente_final', 'fk_residuo',
        'data_triagem', 'data_venda', 'observacao', 'ativo'
    ];

    protected $guarded = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    public function coleta() {
        $this->hasOne(Coleta::class, 'pk_coleta', 'fk_coleta');
    }

    public function clienteFinal() {
        $this->hasOne(ClienteFinal::class, 'pk_cliente_final', 'fk_cliente_final');
    }

    public function residuo() {
        $this->hasOne(Residuo::class, 'pk_residuo', 'fk_residuo');
    }
}

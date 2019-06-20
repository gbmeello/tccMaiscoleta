<?php

namespace App;

use App\Roles;
use Illuminate\Database\Eloquent\Model;

class Permissions extends BaseModel
{
    protected $table = 'permissions';
    protected $primaryKey = 'pk_permission';
    protected $fillable = [
        'nome', 'descricao', 'grupo'
    ];
    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;

    /**
     * relacionamento N:M
    */
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_permission', 'fk_permission', 'fk_role');
    }
}

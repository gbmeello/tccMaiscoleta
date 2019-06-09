<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends BaseModel
{
    protected $table = 'roles';
    protected $primaryKey = 'pk_roles';
    protected $fillable = [
        'nome', 'descricao', 'grupo'
    ];

    protected $hidden = [
        'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;


    /**
     * relacionamento N:1
    */
    public function users()
    {
        return $this->hasMany(Usuario::class, 'fk_role', 'pk_role');
    }

    /**
     * relacionamento N:M
    */
    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'role_permission', 'fk_role', 'fk_permission');
    }
}

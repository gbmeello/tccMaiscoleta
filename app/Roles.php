<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'pk_roles';
    protected $fillable = [
        'nome', 'descricao', 'grupo'
    ];


    /**
     * relacionamento N:1
    */
    public function users()
    {
        return $this->hasMany(\App\Usuario::class, 'fk_role', 'pk_role');
    }

    /**
     * relacionamento N:M
    */
    public function permissions()
    {
        return $this->belongsToMany(\App\Permissions::class, 'role_permission', 'fk_role', 'fk_permission');
    }
}

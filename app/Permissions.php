<?php

namespace App;

use App\Roles;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'pk_permission';
    protected $fillable = [
        'nome', 'descricao', 'grupo'
    ];

    /**
     * relacionamento N:M
    */
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_permission', 'fk_permission', 'fk_role');
    }
}

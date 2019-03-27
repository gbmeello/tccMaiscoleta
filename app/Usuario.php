<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Usuario as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * relacionamento 1:N
    */
    public function role()
    {
        return $this->hasOne(\App\Roles::class, 'id', 'role_id');
    }

    public function hasPermission(Permissions $permission)
    {
        return $this->hasAnyRoles($permission->roles);
    }

    public function hasAnyRoles($roles)
    {
        foreach ( $roles as $role )
        {
            if($role['name'] == $this->role->name)
            {
                return true;
            }
        }
        return false;
    }
}

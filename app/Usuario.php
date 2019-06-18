<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_atualizacao';

    protected $primaryKey = 'pk_usuario';
    protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fk_role', 'nome', 'email', 'senha'
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function setSenhaAttribute($value) {
        $this->attributes['senha'] = Hash::make($value);
    }

    public function setPerfilAttribute($value) {
        $this->attributes['fk_role'] = $value;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'senha', 'remember_token',
    ];

    public $timestamps = false;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // /**
    //  * Return a key value array, containing any custom claims to be added to the JWT.
    //  *
    //  * @return array
    //  */
    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }

    /**
     * relacionamento 1:N
    */
    public function role()
    {
        return $this->belongsTo(Roles::class, 'fk_role', 'pk_role');
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

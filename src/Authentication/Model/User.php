<?php

namespace Kiyon\Laravel\Authentication\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kiyon\Laravel\Authorization\Contracts\AuthorizationUserContract;
use Kiyon\Laravel\Authorization\Traits\AuthorizableUser;
use Kiyon\Laravel\Support\Model\BaseModel;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends BaseModel implements AuthenticatableContract, AuthorizationUserContract, JWTSubject
{

    use Authenticatable, AuthorizableUser, Notifiable;

    protected $table = 'sys_users';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Rest omitted for brevity
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
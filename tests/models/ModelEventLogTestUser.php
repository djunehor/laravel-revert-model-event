<?php

namespace Djunehor\EventRevert\Test\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ModelEventLogTestUser extends Model implements Authenticatable
{
    protected $table = 'test_user_table';
    protected $guarded = ['password'];
    protected $fillable = ['name', 'email', 'password'];

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        $name = $this->getAuthIdentifierName();

        return $this->attributes[$name];
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    public function getRememberToken()
    {
        return 'token';
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
        return 'tokenName';
    }
}

<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Only admins are allowed to create users. So, there is no problem
        // making role attribute fillable.
        'name',
        'role',
        'email',
        'username'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token',
        'created_at',
        'updated_at'
    ];

    /**
     * API token length.
     */
    private static $API_TOKEN_LENGTH = 80;

    /**
     * Check if the uset has admin rights.
     * 
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Return the API token length.
     */
    public static function tokenLength()
    {
        return self::$API_TOKEN_LENGTH;
    }
}

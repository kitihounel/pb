<?php

namespace App\Models;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use CamelCasing;

    protected $fillable = [
        'name',
        'sex',
        'contact',
        'birth_year'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}

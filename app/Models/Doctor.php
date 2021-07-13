<?php

namespace App\Models;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use CamelCasing;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}

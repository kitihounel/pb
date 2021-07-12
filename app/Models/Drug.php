<?php

namespace App\Models;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use CamelCasing;

    protected $fillable = [
        'name',
        'common_name',
        'price',
        'presentation'
    ];
}

<?php

namespace App\Models;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use CamelCasing;

    protected $fillable = [
        'name',
        'inn',
        'price',
        'presentation'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'id' => 'string'
    ];
}

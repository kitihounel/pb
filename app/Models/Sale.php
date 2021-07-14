<?php

namespace App\Models;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use CamelCasing;

    protected $fillable = [
        'transaction_date',
        'prescription_date',
        'patient_name',
        'patient_contact',
        'patient_sex',
        'patient_age',
        'issue_place',
        'doctor_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function drugs()
    {
        return $this->belongsToMany(Drug::class);
    }
}

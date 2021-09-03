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

    protected $casts = [
        'id' => 'string',
        'prescription_date' => 'date',
        'transaction_date' => 'date'
    ];

    /**
     * The drugs on the sale.
     */
    public function drugs()
    {
        return $this->belongsToMany(Drug::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Add or update a drug for the sale.
     * 
     * @param Drug  $drug
     * @param int  $quantity
     */
    public function addDrug(Drug $drug, int $quantity)
    {
        $this->drugs()->syncWithoutDetaching([
            $drug->id => ['quantity' => $quantity]
        ]);
    }

    /**
     * Remove a drug from the sale.
     * 
     * @param Drug  $drug
     */
    public function removeDrug(Drug $drug)
    {
        $this->drugs()->detach($drug->id);
    }
}

<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class StoreSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'prescription_date' => [
                'required',
                'date',
                'before_or_equal:today'
            ],
            'transaction_date' => [
                'required',
                'date',
                'before_or_equal:today',
                'after_or_equal:prescription_date'
            ],
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_contact' => ['required', 'string', 'max:255'],
            'patient_sex' => ['required', 'string', 'in:m,f'],
            'patient_age' => ['required', 'integer', 'min:1', 'max:128'],
            'issue_place' => ['required', 'string', 'max:255'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'drug.id' => ['required', 'integer', 'exists:drugs,id'],
            'drug.quantity' => ['required', 'integer', 'min:1']
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    protected function attributes():  array
    {
        return [
            'transaction_date' => 'transaction date',
            'prescription_date' => 'prescription date',
            'patient_name' => 'patient name',
            'patient_contact' => 'patient contact',
            'patient_sex' => 'patient sex',
            'patient_age' => 'patient age',
            'issue_place' => 'issue place',
            'doctor_id' => 'doctor',
            'drug.id' => 'drug',
            'drug.quantity' => 'quantity'
        ];
    }
}

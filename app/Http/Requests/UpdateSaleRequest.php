<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class UpdateSaleRequest extends FormRequest
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
                'nullable',
                'date',
                'before_or_equal:today'
            ],
            'transaction_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
                'after_or_equal:prescription_date'
            ],
            'patient_name' => ['nullable', 'string', 'max:255'],
            'patient_contact' => ['nullable', 'string', 'max:255'],
            'patient_sex' => ['nullable', 'string', 'in:m,f'],
            'patient_age' => ['nullable', 'integer', 'min:1', 'max:128'],
            'issue_place' => ['nullable', 'string', 'max:255'],
            'doctor_id' => ['nullable', 'integer', 'exists:doctors,id']
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
            'prescription_date' => 'prescription date',
            'transaction_date' => 'transaction date',
            'patient_name' => 'patient name',
            'patient_contact' => 'patient contact',
            'patient_sex' => 'patient sex',
            'patient_age' => 'patient age',
            'issue_place' => 'issue place',
            'doctor_id' => 'doctor'
        ];
    }
}

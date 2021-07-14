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
            'transactionDate' => ['nullable', 'date'],
            'prescriptionDate' => ['nullable', 'date'],
            'patientName' => ['nullable', 'string', 'max:255'],
            'patientContact' => ['nullable', 'string', 'max:255'],
            'patientSex' => ['nullable', 'string', 'in:m,f'],
            'patientAge' => ['nullable', 'integer', 'min:1', 'max:128'],
            'issuePlace' => ['nullable', 'string', 'max:255'],
            'doctorId' => ['nullable', 'integer', 'exists:doctors,id']
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
            'transactionDate' => 'transaction date',
            'prescriptionDate' => 'prescription date',
            'patientName' => 'patient name',
            'patientContact' => 'patient contact',
            'patientSex' => 'patient sex',
            'patientAge' => 'patient age',
            'issuePlace' => 'issue place',
            'doctorId' => 'doctor'
        ];
    }
}

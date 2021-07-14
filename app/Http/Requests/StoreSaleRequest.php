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
            'transactionDate' => ['required', 'date'],
            'prescriptionDate' => ['required', 'date'],
            'patientName' => ['required', 'string', 'max:255'],
            'patientContact' => ['required', 'string', 'max:255'],
            'patientSex' => ['required', 'string', 'in:m,f'],
            'patientAge' => ['required', 'integer', 'min:1', 'max:128'],
            'issuePlace' => ['required', 'string', 'max:255'],
            'doctorId' => ['required', 'integer', 'exists:doctors,id'],
            'drugId' => ['required', 'integer', 'exists:drugs,id'],
            'quantity' => ['required', 'integer', 'min:1']
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
            'doctorId' => 'doctor',
            'drugId' => 'drug',
            'quantity' => 'quantity'
        ];
    }
}

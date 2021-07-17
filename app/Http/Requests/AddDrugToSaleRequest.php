<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class AddDrugToSaleRequest extends FormRequest
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
            'drug_id' => ['required', 'integer', 'exists:drugs,id'],
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
            'drug_id' => 'drug',
            'quantity' => 'quantity'
        ];
    }
}

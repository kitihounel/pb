<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class UpdateDrugRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'inn' => ['nullable', 'string', 'max:255'],
            'price' => [
                'nullable',
                'numeric',
                'regex:/^\d{1,6}(.\d{0,2})?$/',
                'between:1,999999.99'
            ],
            'presentation' => ['nullable', 'string', 'max:255']
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
            'inn' => 'INN',
        ];
    }
}

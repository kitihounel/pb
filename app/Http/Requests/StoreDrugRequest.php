<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class StoreDrugRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'commonName' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'regex:/^\d{1,6}(.\d{0,2})?$/', 'between:1,999999.99'],
            'presentation' => ['required', 'string', 'max:255']
        ];
    }
}

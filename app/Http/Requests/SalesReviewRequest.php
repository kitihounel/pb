<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class SalesReviewRequest extends FormRequest
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
            'start_date' => ['required', 'date'],
            'end_date' => [
                'required',
                'date',
                'before_or_equal:today',
                'before_or_equal:start_date'
            ]
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
            'drug_id' => ['required', 'integer', 'exists:drugs,id'],
            'start_date' => ['required', 'date'],
            'end_date' => [
                'required',
                'date',
                'before_or_equal:today',
                'before_or_equal:start_date'
            ]
        ];
    }
}

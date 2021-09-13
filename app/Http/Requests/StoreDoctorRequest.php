<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'speciality' => ['required', 'string', 'max:255'],
            'med_council_id' => [
                'required',
                'string',
                'max:255',
                'unique:doctors,med_council_id'
            ],
            'phone_number' => ['required', 'string', 'max:255']
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
            'med_council_id' => 'medical council ID',
            'phone_number' => 'phone_number'
        ];
    }
}

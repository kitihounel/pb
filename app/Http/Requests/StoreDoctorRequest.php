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
            'number' => ['required', 'string', 'max:255', 'unique:doctors,number'],
            'contact' => ['required', 'string', 'max:255']
        ];
    }
}

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
            'name' => ['string', 'required', 'max:63'],
            'speciality' => ['string', 'required', 'max:63'],
            'number' => ['string', 'required', 'max:31'],
            'contact' => ['string', 'required', 'max:31']
        ];
    }
}

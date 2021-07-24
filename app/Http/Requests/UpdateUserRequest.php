<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->isAdmin();
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
            'username' => ['nullable', 'alpha', 'max:31'],
            'password' => ['nullable', 'string', 'min:8', 'max:255'],
            'role' => ['nullable', 'string', 'in:user,admin']
        ];
    }
}

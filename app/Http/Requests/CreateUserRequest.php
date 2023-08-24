<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // чтобы запрос отправлялся с токеном
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'password']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Укажите имя',
            'email.required' => 'Укажите email',
            'password.required' => 'Укажите пароль'
        ];
    }
}

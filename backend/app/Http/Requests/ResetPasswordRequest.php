<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'bail|required|email|max:124|exists:users,email',
            'password' => 'bail|required|string|confirmed|regex:/^[a-zA-Z0-9]+$/|min:8',
            'token' => 'required|string',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email должен быть указан!',
            'email.email' => 'Некорректный формат email!',
            'email.max' => 'Email должен содержать менее 124 символов!',
            'email.exists' => 'Пользователь с указанным email не существует!',
            'password.required' => 'Пароль должен быть указан!',
            'password.confirmed' => 'Пароли не совпадают!',
            'password.regex' => 'Пароль допускает только символы английского алфавита и цифры!',
            'password.min' => 'Пароль должен содержать не менее 8 символов!',
            'token.required' => 'Токен не указан или срок его действия истёк!',
            'string' => 'Поле должно быть строкой!',
        ];
    }
}

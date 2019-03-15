<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests
 */
class UpdateUserRequest extends FormRequest
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
            'login' => 'max:24',
            'email' => 'bail|email|unique:users,email,' . $this->id .'|max:124',
            'password' => 'bail|regex:/^[a-zA-Z0-9]+$/|min:8',
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
            'login.max' => 'Логин должен быть не более 24 символов!',
            'email.max' => 'Email должен содержать менее 124 символов!',
            'email.unique' => 'Пользователь с таким email уже существует!',
            'password.min' => 'Пароль должен содержать не менее 8 символов!',
            'regex' => 'Некорректное значение поля!',
            'email' => 'Некорректное значение email!',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /** @var string RUSSIAN_ALPHABET */
    const RUSSIAN_ALPHABET = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';

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
            'login' => 'bail|required|regex:/^[a-zA-Z' . self::RUSSIAN_ALPHABET . '0-9]+$/|max:24|unique:users',
            'password' => 'bail|required|regex:/^[a-zA-Z0-9]+$/|min:8',
            'email' => 'bail|required|max:124|email|unique:users',
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
            'login.required' => 'Логин должен быть указан!',
            'login.max' => 'Логин должен быть не более 24 символов!',
            'email.required' => 'Логин должен быть указан!',
            'email.max' => 'Email должен содержать менее 124 символов!',
            'email.unique' => 'Пользователь с таким email уже существует!',
            'password.required' => 'Пароль должен быть указан!',
            'password.min' => 'Пароль должен содержать не менее 8 символов!',
            'regex' => 'Некорректное значение поля!',
        ];
    }
}

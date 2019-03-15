<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendTokenPasswordRequest extends FormRequest
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
        ];
    }
}

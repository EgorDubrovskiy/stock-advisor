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
            'unique' => 'The :attribute must be unique',
            'regex' => 'The :attribute value is incorrect.',
            'login.max' => 'The :attribute must be equal or less than 24 chars',
            'email.max' => 'The :attribute must be equal or less than 124 chars',
            'password.min' => 'The :attribute must be equal or more than 8 chars',
        ];
    }
}

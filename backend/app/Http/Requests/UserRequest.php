<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'login' => 'bail|required|regex:/^[a-zA-Z0-9]+$/|max:24|unique:users',
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
            'required' => 'The :attribute must be required!',
            'password.min' => 'The :attribute must be at least 8 symbols.',
            'email.max' => 'The :attribute must be less than 124 symbols.',
            'regex' => 'The :attribute value is incorrect.',
            'email.unique' => 'The :attribute must be unique',
        ];
    }
}

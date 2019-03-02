<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAvatarRequest extends FormRequest
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
            'avatar' => 'required|file|mimes:png,jpeg|max:' . config('avatarImageSize.AVATAR_MAX_SIZE'),
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
            'avatar.required' => 'The avatar file is not present in the request',
            'avatar.file' => 'The avatar must be a successfully uploaded file',
            'avatar.mimes' => 'The :attribute must have png or jpeg file extension',
            'avatar.max' => 'The :attribute must be equal or less than 2 mb',
        ];
    }
}

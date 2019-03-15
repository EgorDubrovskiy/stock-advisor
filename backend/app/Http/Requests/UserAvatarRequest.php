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
            'avatar.required' => 'Изображение должно быть указано!',
            'avatar.file' => 'Аватар должен быть файлом!',
            'avatar.mimes' => 'Файл должен иметь png или jpeg расширение!',
            'avatar.max' => 'Размер файла не должен превышать 2 мегабайта!',
        ];
    }
}

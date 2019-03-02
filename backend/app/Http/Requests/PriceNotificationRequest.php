<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceNotificationRequest extends FormRequest
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
        $rules = [];

        switch($this->method())
        {
            case 'POST':
                {
                    $rules = [
                        'user_id' => 'required|regex:/^[0-9]+$/|exists:users,id',
                        'company_id' => 'required|regex:/^[0-9]+$/|exists:companies,id',
                        'price' => 'required|regex:/^\d*\.?\d*$/',
                        'type' => 'required|regex:/^[<>]{1}$/',
                    ];
                    break;
                }
            case 'PUT':
                {
                    $rules = [
                        'user_id' => 'required|regex:/^[0-9]+$/|exists:users,id',
                        'company_id' => 'sometimes|required|regex:/^[0-9]+$/|exists:companies,id',
                        'price' => 'sometimes|required|regex:/^\d*\.?\d*$/',
                        'type' => 'sometimes|required|regex:/^[<>]{1}$/',
                    ];
                    break;
                }
        }

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'regex' => 'Invalid data',
            'exists' => ':attribute not found'
        ];
    }
}

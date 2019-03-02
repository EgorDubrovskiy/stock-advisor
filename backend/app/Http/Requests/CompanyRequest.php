<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'symbol' => 'required|unique:companies|max:8',
            'name' => 'required|max:255',
            'exchange' => 'required|max:255',
            'website' => 'required|max:180',
            'description' => 'nullable',
            'ceo' => 'required|max:64',
            'is_enabled' => 'required|size:1',
            'industry' => 'required',
            'issue_type' => 'required',
            'sector' => 'required',
        ];
    }
}

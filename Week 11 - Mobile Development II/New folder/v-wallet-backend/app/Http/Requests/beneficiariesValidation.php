<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class beneficiariesValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     public function rules()
    {

    return [
        'phone' => 'required|exists:users,phone',
    ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Phone number is required.',
            'phone.exists' => 'User with this phone does not exist.',
        ];
    }
}

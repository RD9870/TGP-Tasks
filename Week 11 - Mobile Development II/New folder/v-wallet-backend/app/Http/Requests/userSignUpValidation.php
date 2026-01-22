<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userSignUpValidation extends FormRequest
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
    public function rules(): array
    {
        return [
            'name'=>['required','string'],
            'phone'=>['required','string','unique:users,phone', 'min:10'],
            'password'=>['required','string'],
            'balance'=>['integer'],
        ];
    }
}

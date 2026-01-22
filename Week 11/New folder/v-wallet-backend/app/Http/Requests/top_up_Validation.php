<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class top_up_Validation extends FormRequest
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
            'userId'=>['required','integer','exists:users,id'],
            'amount'=>['required','numeric'],
            'bankAccountId'=>['required','integer','exists:bank_accounts,id'],
        ];
    }
}

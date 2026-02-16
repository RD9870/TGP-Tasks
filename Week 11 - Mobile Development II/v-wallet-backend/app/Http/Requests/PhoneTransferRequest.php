<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneTransferRequest extends FormRequest
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
        'receiver_phone' => 'required|exists:users,phone',
        'amount' => 'required|numeric|min:1',
    ];
}

public function messages()
{
    return [
        'receiver_phone.required' => 'Receiver phone is required',
        'receiver_phone.exists' => 'Receiver phone does not exist',
        'amount.required' => 'Amount is required',
        'amount.numeric' => 'Amount must be a number',
        'amount.min' => 'Amount must be at least 1',
    ];
}

}

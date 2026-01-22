<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'code'=>['required','string','unique:products,code'],
            'name'=>['required','string'],
            'subcategory_id'=>['required','integer','exists:subcategories,id'],
            'price'=>['required','numeric'],
            'manufacture_id'=>['required','integer','exists:manufacturers,id'],
            'import_company_id'=>['required','integer','exists:import_companies,id'],
            'image'=>['string'],
            'quantity' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
            'minimum' => 'required|integer|min:0',
        ];

    }
}

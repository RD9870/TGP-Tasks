<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
'code' => [
                'sometimes',
                'string',
                Rule::unique('products', 'code')->ignore($this->route('id')),
            ],
            'name' => ['sometimes', 'string', 'max:255'],

            'subcategory_id' => [
                'sometimes',
                'integer',
                'exists:subcategories,id'
            ],

            'price' => ['sometimes', 'numeric', 'min:0'],

            'manufacture_id' => [
                'sometimes',
                'integer',
                'exists:manufacturers,id'
            ],

            'import_company_id' => [
                'sometimes',
                'integer',
                'exists:import_companies,id'
            ],

            'image' => ['sometimes', 'nullable', 'string'],
            'quantity' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}

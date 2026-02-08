<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubcategoryRequest extends FormRequest
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
        // check if the request method is POST (create) or PUT/PATCH (update)
        $isCreate = $this->isMethod('Post');
        // set validation rules based on the request method
        $requirement = $isCreate? "required" : "sometimes";
        // return the validation rules
        return [
            'name'=>[$requirement,'string'],
            'category_id'=>[$requirement,'integer', 'exists:categories,id'],
        ];
    }
}

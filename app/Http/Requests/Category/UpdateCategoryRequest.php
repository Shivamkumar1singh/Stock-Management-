<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return ['name' => 'required|string|max:255|regex:/^[a-zA-Z][a-zA-Z0-9]*$/|unique:categories,name' ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.regex'    => 'Category name must start with an alphabet and contain only letters or numbers.',
            'name.unique'   => 'This category already exists.',
        ];
    }
}
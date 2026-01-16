<?php 

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255|regex:/^[A-Za-z].*/',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'product_price' => 'required|numeric',
            'gst_amount' => 'nullable|numeric|lte:product_price',
            'manufacture_date' => 'required|date|before_or_equal:today',
            'purchase_date' => 'required|date|after_or_equal:manufacture_date|before_or_equal:today',
            'status' => 'required|in:furnished,non_furnished',
            'furnished_date' => 'required_if:status,furnished|nullable|date|after_or_equal:purchase_date',
            'furnished_work' => 'required_if:status,furnished|nullable|string|min:5',            
        ];
    }

    public function messages(): array
    {
        return [
            'product_name.regex' => 'Product name must start with an alphabet.',
            'product_price.min' => 'Enter the price greater than 1.',
            'product_price.numeric' => 'Enter the price in positive number only.',
            
            'gst_amount.min' => 'Enter the GST amount greater than 0.',
            'gst_amount.numeric' => 'Enter the GST amount in positive number only.',
            'gst_amount.lte' => 'Enter the GST amount less than or equal to Product Price.',
            
            'manufacture_date.before_or_equal' => 'Manufacturing date cannot be greater than today date.',
            'purchase_date.after_or_equal' => 'Purchase date must be on or after the manufacture date.',
            
            'product_image.image' => 'The file uploaded must be an image of these format (jpg, jpeg, or png).',
            
            'required' => 'The :attribute field is required.',
        ];
    }
}
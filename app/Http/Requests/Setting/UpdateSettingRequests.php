<?php 

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequests extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sgst_rate' => 'required|numeric|min:0|max:100',
            'cgst_rate' => 'required|numeric|min:0|max:100',
            'depreciation_rate' => 'required|numeric|min:0|max:100',                       
        ];
    }

    public function messages(): array
    {
        return [
            'product_name.regex' => 'Product name must start with an alphabet.',
            'sgst_rate.min' => 'Enter the SGST Rate greater than or equals to 0.',
            'sgst_rate.max' => 'Enter the SGST Rate less than or equals to 100.',
            'sgst_rate.numeric' => 'Enter the SGST Rate in positive number only.',
            
            'cgst_rate.min' => 'Enter the CGST Rate greater than or equals to 0.',
            'cgst_rate.max' => 'Enter the CGST Rate less than or equals to 100.',
            'cgst_rate.numeric' => 'Enter the CGST Rate in positive number only.',

            'depreciation_rate.min' => 'Enter the Depreciation Rate greater than or equals to 0.',
            'depreciation_rate.max' => 'Enter the Deprciation Rate less than or equals to 100.',
            'depreciation_rate.numeric' => 'Enter the Deprciation Rate in positive number only.',            
            
            'required' => 'The :attribute field is required.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name' => 'required',
            'category_id' => 'required',
            'product_price' => 'required | numeric',
            'product_quantity' => 'required | numeric',
            'alert_quantity' => 'required | numeric | lt:product_quantity',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'There is no product name',
        ];
    }
}

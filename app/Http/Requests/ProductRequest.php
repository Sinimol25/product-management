<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'category'          => ['bail', 'required'],
            'product_name'      => ['bail','required','unique:products,product_name,'.$this->id.',id,deleted_at,NULL'],
            'price'             => ['bail','required'],
            'image'             => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048','nullable']
        ];
    }
}

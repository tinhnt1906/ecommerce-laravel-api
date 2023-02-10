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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|max:191',
	        'description'=>'required|max:191',
            'price'=>'required|numeric',
            'quantity'=>'required|numeric',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048',
            'category_id'=>'required|numeric',
        ];
    }
}

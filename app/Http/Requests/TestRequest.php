<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
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
            'name' => 'required',
            'unpublished_at' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'名稱',
            'unpublished_at'=>'截止日期',
        ];
    }
}

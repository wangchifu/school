<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
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
            'url' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'名稱',
            'url'=>'網址',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute 不可空白',
            'url.required' => ':attribute 不可空白',
        ];
    }
}

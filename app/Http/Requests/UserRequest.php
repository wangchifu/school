<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UserRequest extends FormRequest
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
            'username'=>'required|string',
            'name'=>'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'username'=>'帳號',
            'name'=>'姓名',

        ];
    }

    public function messages()
    {
        return [
            'username.required'=>':attribute 不可空白',
            'name.required'=>':attribute 不可空白',
            'name.string'=>'須為字串',
        ];
    }
}

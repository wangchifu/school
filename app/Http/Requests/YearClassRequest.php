<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class YearClassRequest extends FormRequest
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
            'semester'=>'required',
            'class1'=>'required',
            'class2'=>'required',
            'class3'=>'required',
            'class4'=>'required',
            'class5'=>'required',
            'class6'=>'required',
            'class9'=>'required',
        ];
    }

    public function attributes()
    {
        return [
            'semester'=>'學年學期',
            'class1'=>'一年級班級數',
            'class2'=>'二年級班級數',
            'class3'=>'三年級班級數',
            'class4'=>'四年級班級數',
            'class5'=>'五年級班級數',
            'class6'=>'六年級班級數',
            'class9'=>'特教班級數',
        ];
    }

    public function messages()
    {
        return [
            'semester.required'=>':attribute 不可空白',
            'class1.required'=>':attribute 不可空白',
            'class2.required'=>':attribute 不可空白',
            'class3.required'=>':attribute 不可空白',
            'class4.required'=>':attribute 不可空白',
            'class5.required'=>':attribute 不可空白',
            'class6.required'=>':attribute 不可空白',
            'class9.required'=>':attribute 不可空白',
        ];
    }


}

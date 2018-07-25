<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RewardListRequest extends FormRequest
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
            'order_by'=>'required',
            'title'=>'required',
            'description'=>'required',
        ];
    }

    public function attributes()
    {
        return [
            'order_by'=>'順序',
            'title'=>'獎項',
            'description'=>'獎狀內文',
        ];
    }
}

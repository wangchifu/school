<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
            'open_date'=>'required|string',
            'name'=>'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'open_date'=>'會議日期',
            'name'=>'會議名稱',

        ];
    }
}

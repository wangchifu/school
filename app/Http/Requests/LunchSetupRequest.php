<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LunchSetupRequest extends FormRequest
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
            'tea_money'=>'required',
            'stud_money'=>'required',
            'stud_back_money'=>'required',
            'support_part_money'=>'required',
            'support_all_money'=>'required',
            'die_line'=>'required',
            'place.*' => 'required',
            'factory.*' => 'required',
        ];
    }

    public function attributes()
    {
        $att = [
            'semester'=>'學期',
            'tea_money'=>'教職員工收費',
            'stud_money'=>'學生收費',
            'stud_back_money'=>'學生退費',
            'support_part_money'=>'部分補助',
            'support_all_money'=>'全額補助',
            'die_line'=>'允許師生最慢幾天前退餐',
        ];

        for($i=0;$i<10;$i++){
            $j = $i+1;
            $att['place.'.$i] = "教師供餐地點".$j;
        }
        for($i=0;$i<10;$i++){
            $j = $i+1;
            $att['factory.'.$i] = "廠商".$j;
        }
        return $att;
    }

}

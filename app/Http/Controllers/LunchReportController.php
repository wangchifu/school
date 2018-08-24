<?php

namespace App\Http\Controllers;

use App\LunchStuDate;
use App\LunchStuOrder;
use App\LunchTeaDate;
use Illuminate\Http\Request;

class LunchReportController extends Controller
{
    public function for_factory(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        //這個學期各餐期的id key是日期
        $order_id_array = get_lunch_order_array($semester);

        //key value 互換 key是id
        $lunch_orders = array_flip($order_id_array);
        if(!empty($lunch_orders)) {
            $lunch_order_id = (empty($request->input('select_order_id'))) ? $lunch_orders[substr(date('Y-m'), 0, 7)] : $request->input('select_order_id');
        }else{
            $lunch_order_id="";
        }
        $order_dates = get_lunch_order_dates($semester);

        $i = 0;
        $this_order_dates=[];
        foreach ($order_dates as $k => $v) {
            if ($v == 1 and substr($k, 0, 7) == $order_id_array[$lunch_order_id]) {
                $this_order_dates[$i] = $k;
                $i++;
            }
        }

        //教職
        $tea_order_datas = LunchTeaDate::where('lunch_order_id', '=', $lunch_order_id)
            ->where('enable','=','1')
            ->orderBy('place','ASC')
            ->get();

        $order_data_tea = [];


        foreach ($tea_order_datas as $tea_order_data) {
            if ($tea_order_data->eat_style == "1" and $tea_order_data->enable == "1") {
                if ( ! isset($order_data_tea[$tea_order_data->place][$tea_order_data->order_date]['m'])) {
                    $order_data_tea[$tea_order_data->place][$tea_order_data->order_date]['m'] = null;
                }
                $order_data_tea[$tea_order_data->place][$tea_order_data->order_date]['m']++;
            } elseif ($tea_order_data->eat_style == "2" and $tea_order_data->enable == "1") {
                if ( ! isset($order_data_tea[$tea_order_data->place][$tea_order_data->order_date]['g'])) {
                    $order_data_tea[$tea_order_data->place][$tea_order_data->order_date]['g'] = null;
                }
                $order_data_tea[$tea_order_data->place][$tea_order_data->order_date]['g'] ++;
            }
        }

        $order_data = [];


        //學生
        $stu_order_datas = LunchStuDate::where('lunch_order_id', '=', $lunch_order_id)
            ->where('eat_style','<>','3')
            ->orderBy('class_id')->orderBy('order_date')->get();
        foreach ($stu_order_datas as $stu_order_data) {
            if ($stu_order_data->eat_style == "1" and $stu_order_data->enable == "eat") {
                if ( ! isset($order_data[$stu_order_data->class_id][$stu_order_data->order_date]['m'])) {
                    $order_data[$stu_order_data->class_id][$stu_order_data->order_date]['m'] = null;
                }
                $order_data[$stu_order_data->class_id][$stu_order_data->order_date]['m']++;
            } elseif ($stu_order_data->eat_style == "2" and $stu_order_data->enable == "eat") {
                if ( ! isset($order_data[$stu_order_data->class_id][$stu_order_data->order_date]['g'])) {
                    $order_data[$stu_order_data->class_id][$stu_order_data->order_date]['g'] = null;
                }
                $order_data[$stu_order_data->class_id][$stu_order_data->order_date]['g']++;
            }
        }

        $stu_orders_array = LunchStuOrder::where('eat_style','<>','3')
            ->orderBy('student_num')->get();
        $stu_default = [];
        foreach($stu_orders_array as $stu_order){
            if($stu_order->out_in != "in") {
                if (!isset($stu_default[substr($stu_order->student_num, 0, 3)]['m'])) $stu_default[substr($stu_order->student_num, 0, 3)]['m'] = 0;
                if (!isset($stu_default[substr($stu_order->student_num, 0, 3)]['g'])) $stu_default[substr($stu_order->student_num, 0, 3)]['g'] = 0;
                if ($stu_order->eat_style == "1") {
                    $stu_default[substr($stu_order->student_num, 0, 3)]['m']++;
                }
                if ($stu_order->eat_style == "2") {
                    $stu_default[substr($stu_order->student_num, 0, 3)]['g']++;
                }
            }
        }


        $data = [
            'semester' => $semester,
            'order_id_array' => $order_id_array,
            'lunch_order_id' => $lunch_order_id,
            'this_order_dates' => $this_order_dates,
            'order_data' => $order_data,
            'order_data_tea' => $order_data_tea,
            'stu_default' => $stu_default,
        ];
        return view('lunch_reports.for_factory', $data);
    }
}

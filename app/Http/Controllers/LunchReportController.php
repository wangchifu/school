<?php

namespace App\Http\Controllers;

use App\LunchOrderDate;
use App\LunchSetup;
use App\LunchStuDate;
use App\LunchStuOrder;
use App\LunchTeaDate;
use Illuminate\Http\Request;

class LunchReportController extends Controller
{
    public function factory()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }

        return view('lunch_reports.factory');
    }
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


    public function tea_everyday(Request $request)
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }

        //目前是哪一個學期
        $semester = get_semester();

        //查新學期設好了沒
        $check_new_semester = LunchOrderDate::where('semester','=',$semester)->first();
        if(empty($check_new_semester)){
            $words = "新學期尚未設定好！";
            return view('layouts.error',compact('words'));
        }


        //id當key
        $orders = get_lunch_order_array($semester);
        //月份當key
        $orders2 = array_flip($orders);

        $this_mon = date('Y-m');
        $this_order_id = $orders2[$this_mon];
        //選取的月份id
        $order_id = (empty($request->input('order_id'))) ? $this_order_id : $request->input('order_id');

        //選取的月份
        $mon = $orders[$order_id];

        $o_order_dates = get_lunch_order_dates($semester);
        $i = 0;
        //訂餐日期array
        foreach ($o_order_dates as $k => $v) {
            if (substr($k, 0, 7) == $mon and $v == 1) {
                $order_dates[$i] = $k;
                $i++;
            }
        }
        //訂餐者資料
        $user_datas = [];
        $order_datas = LunchTeaDate::where('lunch_order_id', '=', $order_id)
            ->orderBy('place','ASC')
            ->orderBy('user_id')
            ->get();
        foreach ($order_datas as $order_data) {
            $user_datas[$order_data->user->name][$order_data->order_date]['enable'] = $order_data->enable;
            $user_datas[$order_data->user->name][$order_data->order_date]['eat_style'] = $order_data->eat_style;
            $user_datas[$order_data->user->name][$order_data->order_date]['place'] = $order_data->place;
        }

        $data = [
            'this_order_id' => $this_order_id,
            'mon' => $mon,
            'orders' => $orders,
            'semester' => $request->input('semester'),
            'order_dates' => $order_dates,
            'user_datas' => $user_datas,
        ];
        return view('lunch_reports.tea_everyday', $data);
    }

    public function tea_money(Request $request)
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }
        //目前是哪一個學期
        $semester = get_semester();


        //查新學期設好了沒
        $check_new_semester = LunchOrderDate::where('semester','=',$semester)->first();
        if(empty($check_new_semester)){
            $words = "新學期尚未設定好！";
            return view('layouts.error',compact('words'));
        }


        //id當key
        $orders = get_lunch_order_array($semester);
        //月份當key
        $orders2 = array_flip($orders);

        $this_mon = date('Y-m');
        $this_order_id = $orders2[$this_mon];
        //選取的月份id
        $order_id = (empty($request->input('order_id'))) ? $this_order_id : $request->input('order_id');

        //選取的月份
        $mon = $orders[$order_id];


        $order_datas = LunchTeaDate::where('semester', '=', $semester)
            ->where('lunch_order_id',$order_id)
            ->orderBy('place','ASC')
            ->orderBy('user_id')
            ->get();

        $user_datas = [];
        foreach ($order_datas as $order_data) {
            if ($order_data->enable == "1") {
                if( !isset($user_datas[$order_data->user->name])) $user_datas[$order_data->user->name]=null;
                $user_datas[$order_data->user->name]++;
            }
        }

        $setup = LunchSetup::where('semester',$semester)->first();
        $tea_money = $setup->tea_money;


        $data = [
            'this_order_id' => $this_order_id,
            'order_id'=>$order_id,
            'mon' => $mon,
            'orders' => $orders,
            'semester' => $request->input('semester'),
            'user_datas' => $user_datas,
            'tea_money' => $tea_money,
        ];
        return view('lunch_reports.tea_money', $data);
    }

    public function tea_money_print($order_id)
    {
        //目前是哪一個學期
        $semester = get_semester();

        $order_datas = LunchTeaDate::where('semester',$semester)
            ->where('lunch_order_id', '=', $order_id)
            ->orderBy('place','ASC')
            ->orderBy('user_id')
            ->get();

        $user_datas = [];
        foreach ($order_datas as $order_data) {
            if ($order_data->enable == "1") {
                if(!isset($user_datas[$order_data->user->name][substr($order_data->order_date, 0, 7)])) $user_datas[$order_data->user->name][substr($order_data->order_date, 0, 7)]=null;
                $user_datas[$order_data->user->name][substr($order_data->order_date, 0, 7)]++;
            }
        }

        $setup = LunchSetup::where('semester',$semester)->first();
        $tea_money = $setup->tea_money;

        $data = [
            'semester'=>$semester,
            'user_datas' => $user_datas,
            'tea_money' => $tea_money
        ];
        return view('lunch_reports.tea_money_print', $data);
    }

    public function stu(Request $request)
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }
        //目前是哪一個學期
        $semester = get_semester();

        //查新學期設好了沒
        $check_new_semester = LunchOrderDate::where('semester','=',$semester)->first();
        if(empty($check_new_semester)){
            $words = "新學期尚未設定好！";
            return view('layouts.error',compact('words'));
        }

        //id當key
        $orders = get_lunch_order_array($semester);
        //月份當key
        $orders2 = array_flip($orders);
        $this_mon = date('Y-m');
        $this_order_id = $orders2[$this_mon];


        //選取的月份id
        $order_id = (empty($request->input('order_id'))) ? $this_order_id : $request->input('order_id');

        //選取的月份
        $mon = $orders[$order_id];


        $setup = LunchSetup::where('semester',$semester)->first();
        if($setup->stud_money=="0" and $setup->stud_back_money=="0" and $setup->support_part_money=="0"){
            //若為全補助
            $stu_dates = LunchStuDate::where('lunch_order_id',$order_id)
                ->where('enable','eat')
                ->get();
            foreach($stu_dates as $stu_date){
                if(!isset($stu_data[$stu_date->class_id])) {
                    $stu_data[$stu_date->class_id] = 0;
                }
                    $stu_data[$stu_date->class_id]++;
            }
        }else{
            //部分補助
        }
        ksort($stu_data);
        $data = [
            'this_order_id' => $this_order_id,
            'order_id'=>$order_id,
            'mon' => $mon,
            'orders' => $orders,
            'stu_data'=>$stu_data,
        ];
        return view('lunch_reports.stu',$data);

    }

    public function stu_p_id()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }
        //目前是哪一個學期
        $semester = get_semester();
        $stu_p_ids = LunchStuOrder::where('semester',$semester)
            ->where('eat_style','!=','3')
            ->get();
        //dd($stu_p_ids);
        $stu_p_id_data = [];
        foreach($stu_p_ids as $stu_p_id){
            $class_id = substr($stu_p_id->student_num,0,3);
            if($stu_p_id->out_in != "out"){
                if(!isset($stu_p_id_data[$class_id]['s101'])) $stu_p_id_data[$class_id]['s101'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s201'])) $stu_p_id_data[$class_id]['s201'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s202'])) $stu_p_id_data[$class_id]['s202'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s203'])) $stu_p_id_data[$class_id]['s203'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s204'])) $stu_p_id_data[$class_id]['s204'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s205'])) $stu_p_id_data[$class_id]['s205'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s206'])) $stu_p_id_data[$class_id]['s206'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s207'])) $stu_p_id_data[$class_id]['s207'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s208'])) $stu_p_id_data[$class_id]['s208'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s209'])) $stu_p_id_data[$class_id]['s209'] = 0;
                if(!isset($stu_p_id_data[$class_id]['s210'])) $stu_p_id_data[$class_id]['s210'] = 0;
                if($stu_p_id->p_id==101) $stu_p_id_data[$class_id]['s101']++;
                if($stu_p_id->p_id==201) $stu_p_id_data[$class_id]['s201']++;
                if($stu_p_id->p_id==202) $stu_p_id_data[$class_id]['s202']++;
                if($stu_p_id->p_id==203) $stu_p_id_data[$class_id]['s203']++;
                if($stu_p_id->p_id==204) $stu_p_id_data[$class_id]['s204']++;
                if($stu_p_id->p_id==205) $stu_p_id_data[$class_id]['s205']++;
                if($stu_p_id->p_id==206) $stu_p_id_data[$class_id]['s206']++;
                if($stu_p_id->p_id==207) $stu_p_id_data[$class_id]['s207']++;
                if($stu_p_id->p_id==208) $stu_p_id_data[$class_id]['s208']++;
                if($stu_p_id->p_id==209) $stu_p_id_data[$class_id]['s209']++;
                if($stu_p_id->p_id==210) $stu_p_id_data[$class_id]['s210']++;
            }

        }
        if(!empty($stu_p_id_data)){
            ksort($stu_p_id_data);
        }
        $data = [
            'stu_p_id_data'=>$stu_p_id_data,
        ];

        return view('lunch_reports.stu_p_id',$data);
    }
}

<?php
///////////////////5.午餐模組專用///////////////////////////////
///取某學期的各個餐期array
if (! function_exists('get_order_id_array')) {
    function get_lunch_order_array($semester){
        $orders = \App\LunchOrder::where('semester','=',$semester)->orderBy('id')->get();
        $order_id_array=[];
        foreach($orders as $order){
            $order_id_array[$order->id] =$order->name;
        }
        return $order_id_array;
    }
}

//此學期的每日供餐狀況
if(! function_exists('get_lunch_order_dates')){
    function get_lunch_order_dates($semester){
        $lunch_order_dates = \App\LunchOrderDate::where('semester','=',$semester)->get();
        $order_dates=[];
        if($lunch_order_dates) {
            foreach ($lunch_order_dates as $v) {
                $order_dates[$v->order_date] = $v->enable;
            }
        }
        return $order_dates;
    }
}
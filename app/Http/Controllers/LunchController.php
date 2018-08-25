<?php

namespace App\Http\Controllers;

use App\LunchOrder;
use App\LunchOrderDate;
use App\LunchSetup;
use App\LunchTeaDate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LunchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lunch_setups = LunchSetup::orderBy('semester','DESC')->paginate(4);
        $data = [
            'lunch_setups'=>$lunch_setups,
        ];
        return view('lunches.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($semester)
    {
        //查新學期設好了沒
        $check_new_semester = LunchOrderDate::where('semester','=',$semester)->first();
        if(empty($check_new_semester)){
            $words = "新學期尚未設定好！";
            return view('layouts.error',compact('words'));
        }

        //此學期的每一天
        $semester_dates = get_semester_dates($semester);
        $order_dates = LunchOrderDate::where('semester',$semester)->get();
        $get = 0;
        foreach($order_dates as $order_date){
            //取第一個enable =1 的供餐日
            if($order_date->enable==1 and $get!=1){
                $first_enable_date = $order_date->order_date;
                $get = 1;
            }
            $order_date_data[$order_date->order_date] = $order_date->enable;
        }


        //最後停止日期
        $lunch_setup = LunchSetup::where('semester',$semester)->first();
        $die_line = $lunch_setup->die_line;
        $dt = Carbon::createFromFormat('Y-m-d', $first_enable_date)->subDays($die_line)->toDateTimeString();
        $die_date = str_replace('-','',substr($dt,0,10));
        if($lunch_setup->tea_open==null) {
            if (date('Ymd') > $die_date) {
                $words = "已過訂餐日期限，忘記訂餐請洽管理員！";
                return view('layouts.error', compact('words'));
            }
        }

        $lunch_setup = LunchSetup::where('semester',$semester)->first();
        $places = explode(',',$lunch_setup->place);
        $factories = explode(',',$lunch_setup->factory);

        $data = [
            'semester'=>$semester,
            'semester_dates'=>$semester_dates,
            'order_date_data'=>$order_date_data,
            'places'=>$places,
            'factories'=>$factories,
        ];
        return view('lunches.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order_date = $request->input('order_date');
        $semester_dates = get_semester_dates($request->input('semester'));

        $all = [];
        foreach ($semester_dates as $k1 => $v1) {
            foreach ($v1 as $k2 => $v2) {
                $att['order_date'] = $v2;
                if (!empty($order_date[$v2])) {
                    $att['enable'] = "1";
                } else {
                    $att['enable'] = "0";
                }
                $att['semester'] = $request->input('semester');

                $name = substr($v2, 0, 7);
                $lunch_order = LunchOrder::where('name',$name)->first();
                $att['lunch_order_id'] = $lunch_order->id;

                $att['user_id'] = auth()->user()->id;
                $att['place'] = $request->input('place');
                $att['factory'] = $request->input('factory');
                $att['eat_style'] = $request->input('eat_style');


                $one = [
                    'order_date'=>$att['order_date'],
                    'enable'=>$att['enable'],
                    'semester'=>$att['semester'],
                    'lunch_order_id'=>$att['lunch_order_id'],
                    'user_id'=>$att['user_id'],
                    'place'=>$att['place'],
                    'factory'=>$att['factory'],
                    'eat_style'=>$att['eat_style'],
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ];
                array_push($all,$one);
            }
        }

        LunchTeaDate::insert($all);

        return redirect()->route('lunches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($semester)
    {
        //die_line
        $lunch_setup = LunchSetup::where('semester',$semester)->first();
        $die_line = $lunch_setup->die_line;
        $dt = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->addDays($die_line)->toDateTimeString();
        $die_date = str_replace('-','',substr($dt,0,10));

        //此學期的每一天
        $semester_dates = get_semester_dates($semester);

        //此學期的供餐日
        $order_dates = LunchOrderDate::where('semester',$semester)->get();
        foreach($order_dates as $order_date){
            $order_date_data[$order_date->order_date] = $order_date->enable;
        }

        //此教師的訂餐日
        $tea_dates = LunchTeaDate::where('semester',$semester)
            ->where('user_id',auth()->user()->id)
            ->get();
        foreach($tea_dates as $tea_date){
            $tea_date_data[$tea_date->order_date] = $tea_date->enable;
        }

        $tea_date = LunchTeaDate::where('semester',$semester)
            ->where('user_id',auth()->user()->id)
            ->first();
        $tea_place = $tea_date->place;
        $tea_factory = $tea_date->factory;
        $tea_eat_style = $tea_date->eat_style;


        $data = [
            'semester'=>$semester,
            'semester_dates'=>$semester_dates,
            'order_date_data'=>$order_date_data,
            'tea_date_data'=>$tea_date_data,
            'tea_place'=>$tea_place,
            'tea_factory'=>$tea_factory,
            'tea_eat_style'=>$tea_eat_style,
            'die_date'=>$die_date,
            'die_line'=>$die_line,
        ];
        return view('lunches.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        //是否停止學生退餐了
        $setup = LunchSetup::where('semester',$semester)
            ->first();
        if($setup->disable == "1") {
            $words = "本學期師生已停止退餐！！";
            return view('layouts.error', compact('words'));
        }

        $order_date = $request->input('order_date');
        $semester_dates = get_semester_dates($request->input('semester'));

        foreach ($semester_dates as $k1 => $v1) {
            foreach ($v1 as $k2 => $v2) {
                if (!empty($order_date[$v2])) {
                    $att['enable'] = "1";
                } else {
                    $att['enable'] = "0";
                }
                $tea_date = LunchTeaDate::where('order_date',$v2)
                    ->where('user_id',auth()->user()->id)
                    ->first();
                $tea_date->update($att);

            }
        }
        return redirect()->route('lunches.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

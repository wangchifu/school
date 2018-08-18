<?php

namespace App\Http\Controllers;

use App\LunchOrder;
use App\LunchOrderDate;
use App\LunchSetup;
use Illuminate\Http\Request;

class LunchOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($semester)
    {
        $admin = check_admin(3);

        //此學期的每一天
        $semester_dates = get_semester_dates($semester);


        $data = [
            'admin'=>$admin,
            'semester'=>$semester,
            'semester_dates'=>$semester_dates,
        ];
        return view('lunch_orders.create',$data);
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

        $last_name = "";
        $all = [];
        foreach ($semester_dates as $k1 => $v1) {
            foreach ($v1 as $k2 => $v2) {
                $att['name'] = substr($v2, 0, 7);
                if ($att['name'] != $last_name) {
                    $att['semester'] = $request->input('semester');
                    $att['enable'] = 1;
                    $lunch_order = LunchOrder::create($att);
                }
                $last_name = $att['name'];
                $att2['order_date'] = $v2;
                if (!empty($order_date[$v2])) {
                    $att2['enable'] = "1";
                } else {
                    $att2['enable'] = "0";
                }
                $att2['semester'] = $request->input('semester');
                $att2['lunch_order_id'] = $lunch_order->id;
                $one = [
                    'order_date'=>$att2['order_date'],
                    'enable'=>$att2['enable'],
                    'semester'=>$att2['semester'],
                    'lunch_order_id'=>$att2['lunch_order_id'],
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ];
                array_push($all,$one);
            }
        }
        LunchOrderDate::insert($all);


        return redirect()->route('lunch_setups.index');
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
        $admin = check_admin(3);

        //此學期的每一天
        $semester_dates = get_semester_dates($semester);
        $order_dates = LunchOrderDate::where('semester',$semester)->get();
        foreach($order_dates as $order_date){
            $order_date_data[$order_date->order_date] = $order_date->enable;
        }


        $data = [
            'admin'=>$admin,
            'semester'=>$semester,
            'semester_dates'=>$semester_dates,
            'order_date_data'=>$order_date_data,
        ];
        return view('lunch_orders.edit',$data);
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
        //刪除舊的
        $semester = $request->input('semester');
        LunchOrder::where('semester',$semester)->delete();
        LunchOrderDate::where('semester',$semester)->delete();

        $order_date = $request->input('order_date');
        $semester_dates = get_semester_dates($request->input('semester'));

        $last_name = "";
        $all = [];
        foreach ($semester_dates as $k1 => $v1) {
            foreach ($v1 as $k2 => $v2) {
                $att['name'] = substr($v2, 0, 7);
                if ($att['name'] != $last_name) {
                    $att['semester'] = $request->input('semester');
                    $att['enable'] = 1;
                    $lunch_order = LunchOrder::create($att);
                }
                $last_name = $att['name'];
                $att2['order_date'] = $v2;
                if (!empty($order_date[$v2])) {
                    $att2['enable'] = "1";
                } else {
                    $att2['enable'] = "0";
                }
                $att2['semester'] = $request->input('semester');
                $att2['lunch_order_id'] = $lunch_order->id;
                $one = [
                    'order_date'=>$att2['order_date'],
                    'enable'=>$att2['enable'],
                    'semester'=>$att2['semester'],
                    'lunch_order_id'=>$att2['lunch_order_id'],
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ];
                array_push($all,$one);
            }
        }
        LunchOrderDate::insert($all);


        return redirect()->route('lunch_setups.index');
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

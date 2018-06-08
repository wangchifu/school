<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\ClassroomOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClassroomOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Classroom::where('disable','=',null)->get();
        $data = [
            'classrooms'=>$classrooms,
        ];
        return view('classroom_orders.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        if(date('w') =="0"){
            $sunday = new Carbon('this Sunday');
        }else{
            $sunday = new Carbon('last Sunday');
        }


        $week = [
            '0'=>$sunday->toDateString(),
            '1'=>$sunday->addDay()->toDateString(),
            '2'=>$sunday->addDay()->toDateString(),
            '3'=>$sunday->addDay()->toDateString(),
            '4'=>$sunday->addDay()->toDateString(),
            '5'=>$sunday->addDay()->toDateString(),
            '6'=>$sunday->addDay()->toDateString(),
        ];

        $check_orders = ClassroomOrder::where('classroom_id',$classroom->id)
            ->get();
        $has_order = [];
        foreach($check_orders as $check_order){
            $has_order[$check_order->order_date][$check_order->section]['id'] = $check_order->user_id;
            $has_order[$check_order->order_date][$check_order->section]['user_name'] = $check_order->user->name;
        }

        $data = [
            'classroom'=>$classroom,
            'week'=>$week,
            'has_order'=>$has_order,
        ];
        return view('classroom_orders.show',$data);
    }

    public function select($classroom_id,$secton,$order_date)
    {
        $att['classroom_id'] = $classroom_id;
        $att['order_date'] = $order_date;
        $att['section'] = $secton;
        $att['user_id'] = auth()->user()->id;
        $check = ClassroomOrder::where('classroom_id',$classroom_id)
            ->where('section',$secton)
            ->where('order_date',$order_date)
            ->first();
        if(empty($check)){
            ClassroomOrder::create($att);
        }else{
            $words = "該節被預約了！";
                return view('layouts.error',compact('words'));
        }

        return redirect()->route('classroom_orders.show',$classroom_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        ClassroomOrder::where('user_id',auth()->user()->id)
            ->where('classroom_id',$request->input('classroom_id'))
            ->where('order_date',$request->input('order_date'))
            ->where('section',$request->input('section'))
            ->delete();
        return redirect()->route('classroom_orders.show',$request->input('classroom_id'));
    }
}

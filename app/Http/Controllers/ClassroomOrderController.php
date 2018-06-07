<?php

namespace App\Http\Controllers;

use App\Classroom;
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
            '日'=>$sunday->toDateString(),
            '一'=>$sunday->addDay()->toDateString(),
            '二'=>$sunday->addDay()->toDateString(),
            '三'=>$sunday->addDay()->toDateString(),
            '四'=>$sunday->addDay()->toDateString(),
            '五'=>$sunday->addDay()->toDateString(),
            '六'=>$sunday->addDay()->toDateString(),
        ];

        $data = [
            'classroom'=>$classroom,
            'week'=>$week,
        ];
        return view('classroom_orders.show',$data);
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
    public function destroy($id)
    {
        //
    }
}

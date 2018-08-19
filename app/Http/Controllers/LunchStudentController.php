<?php

namespace App\Http\Controllers;

use App\YearClass;
use Illuminate\Http\Request;

class LunchStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        //判斷是否為老師
        $year_class = YearClass::where('semester','=',$semester)->where('user_id','=',auth()->user()->id)->first();
        if($year_class) {
            $class_name = $year_class->name;
            $year_class_id = $year_class->id;
            $class_id = $year_class->year_class;
            $is_tea = "1";
        }else{
            $class_name = "";
            $year_class_id = "";
            $class_id = "";
            $is_tea = "0";
        }
        //管理者
        $admin = check_admin(3);
        if($admin){
            $year_class = YearClass::where('semester','=',$semester)->where('year_class','=',$request->input('class_id'))->first();
            if($year_class){
                $class_name = $year_class->name;
                $year_class_id = $year_class->id;
                $class_id = $year_class->year_class;
            }

            $is_tea = "1";
        }

        $data = [
            'class_name'=>$class_name,
            'year_class_id'=>$year_class_id,
            'class_id'=>$class_id,
            'is_tea'=>$is_tea,
        ];
        return view('lunch_students.index',$data);
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

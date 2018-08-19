<?php

namespace App\Http\Controllers;

use App\LunchOrder;
use App\LunchOrderDate;
use App\LunchSetup;
use App\LunchStuDate;
use App\LunchStuOrder;
use App\SemesterStudent;
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

        if(empty($is_tea)){
            $words = "你不是級任老師或管理者！";
            return view('layouts.error',compact('words'));
        }

        //查新學期設好了沒
        $check_new_semester = LunchOrderDate::where('semester','=',$semester)->first();
        if(empty($check_new_semester)){
        $words = "新學期尚未設定好！";
        return view('layouts.error',compact('words'));
    }

        //查該班送出訂單了沒
        if($class_id) {
            $check_order = LunchStuOrder::where('semester', $semester)
                ->where('student_num', 'like', $class_id . '%')
                ->first();
            if (!empty($check_order->id)) {
                return redirect()->route('lunch_students.edit', $class_id);
            }
        }



        if($year_class_id){
            $stu_datas = SemesterStudent::where('year_class_id', '=', $year_class_id)->where('at_school','=','1')->orderBy('num')->get();
            foreach ($stu_datas as $stu) {
                $stu_data[$stu->num]['name'] = $stu->student->name;
                $stu_data[$stu->num]['sex'] = $stu->student->sex;
                $stu_data[$stu->num]['id'] = $stu->student->id;
            }
        }else{
            $stu_data=[];
        }

        $data = [
            'semester'=>$semester,
            'class_name'=>$class_name,
            'year_class_id'=>$year_class_id,
            'class_id'=>$class_id,
            'is_tea'=>$is_tea,
            'admin'=>$admin,
            'stu_data'=>$stu_data,
        ];
        return view('lunch_students.create',$data);
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
        $semester = $request->input('semester');
        $eat_style = $request->input('eat_style');
        $p_id = $request->input('p_id');
        $student_num = $request->input('student_num');

        //這個學期各餐期的id
        $order_id_array = [];
        $orders = LunchOrder::where('semester','=',$semester)->orderBy('id')->get();
        foreach($orders as $order){
            $order_id_array[$order->name] =$order->id;
        }

        //每個餐期供餐情況
        $order_dates=[];
        $lunch_order_dates = LunchOrderDate::where('semester','=',$semester)->get();
        if($lunch_order_dates) {
            foreach ($lunch_order_dates as $v) {
                $order_dates[$v->order_date] = $v->enable;
            }
        }

        $year_calss = YearClass::where('semester','=',$semester)->where('year_class','=',$request->input('class_id'))->first();

        $create_stu_date = [];
        $create_stu_order = [];
        foreach($order_dates as $k=>$v) {
            foreach ($year_calss->semester_students as $semester_student) {
                //轉出生不要在列
                if($semester_student->at_school == "1") {
                    $att['order_date'] = $k;
                    if ($v == "0") $att['enable'] = "not";
                    if ($v == "1") $att['enable'] = "eat";
                    $att['semester'] = $semester;
                    $att['lunch_order_id'] = $order_id_array[substr($k, 0, 7)];
                    $att['student_id'] = $semester_student->student_id;
                    $att['class_id'] = $request->input('class_id');
                    $att['num'] = $semester_student->num;
                    $att['p_id'] = $p_id[$semester_student->student_id];
                    $att['eat_style'] = $eat_style[$semester_student->student_id];
                    if ($att['eat_style'] == "3" and $v == "1") $att['enable'] = "no_eat";
                    $new_one = [
                        "order_date"=>$att['order_date'],
                        "enable"=>$att['enable'],
                        "semester"=>$att['semester'],
                        "lunch_order_id"=>$att['lunch_order_id'],
                        "student_id"=>$att['student_id'],
                        "class_id"=>$att['class_id'],
                        "num"=>$att['num'],
                        "p_id"=>$att['p_id'],
                        "eat_style"=>$att['eat_style'],
                    ];
                    array_push($create_stu_date, $new_one);

                }
            }
        }

        LunchStuDate::insert($create_stu_date);


        foreach($student_num as $k=>$v){
            $att2['semester'] = $semester;
            $att2['student_id'] = $k;
            $att2['student_num'] = $v;
            $att2['eat_style'] = $eat_style[$k];
            $att2['p_id'] = $p_id[$k];
            //LunchStuOrder::create($att2);
            $new_one = [
                "semester"=>$att2['semester'],
                "student_id"=>$att2['student_id'],
                "student_num"=>$att2['student_num'],
                "eat_style"=>$att2['eat_style'],
                "p_id"=>$att2['p_id'],
            ];
            array_push($create_stu_order, $new_one);

        }

        LunchStuOrder::insert($create_stu_order);

        return redirect()->route('lunch_students.index');

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
    public function edit($class_id)
    {
        //目前是哪一個學期
        $semester = get_semester();

        //管理者
        $admin = check_admin(3);

        //確認該班為該使用者所有
        $check_tea = YearClass::where('semester','=',$semester)->where('user_id','=',auth()->user()->id)->first();
        $check_class_id = ($check_tea)?$check_tea->year_class:"";
        if($check_class_id != $class_id and $admin==0){
            $words = "你不是該班級任老師！";
            return view('layouts.error',compact('words'));
        }


        $year_class = YearClass::where('semester','=',$semester)->where('year_class','=',$class_id)->first();
        if($year_class){
            $class_name = $year_class->name;
            $year_class_id = $year_class->id;
            $class_id = $year_class->year_class;
        }

        if($year_class_id){
            $stu_datas = SemesterStudent::where('year_class_id', '=', $year_class_id)->where('at_school','=','1')->orderBy('num')->get();
            foreach ($stu_datas as $stu) {
                $stu_data[$stu->num]['name'] = $stu->student->name;
                $stu_data[$stu->num]['sex'] = $stu->student->sex;
                $stu_data[$stu->num]['id'] = $stu->student->id;
            }
        }else{
            $stu_data=[];
        }

        $data = [
            'admin'=>$admin,
            'class_id'=>$class_id,
            'stu_data'=>$stu_data,
        ];
        return view('lunch_students.edit',$data);
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

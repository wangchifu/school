<?php

namespace App\Http\Controllers;

use App\LunchCheck;
use App\LunchOrder;
use App\LunchOrderDate;
use App\LunchSatisfaction;
use App\LunchSatisfactionClass;
use App\LunchSetup;
use App\LunchStuDate;
use App\LunchStuOrder;
use App\LunchTeaDate;
use App\SemesterStudent;
use App\YearClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class LunchStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //目前是哪一個學期
        $semester = get_semester();

        //判斷是否為級任老師
        $tea_class = check_tea();

        //是否為管理者
        $admin = check_admin(3);

        if($tea_class['is_tea']==0 and $admin==0){
            $words = "你不是級任老師或管理員！";
            return view('layouts.error',compact('words'));
        }



        if($tea_class['is_tea']){
            //級任把班級記錄在session
            session(['class_id'=>$tea_class['class_id']]);
        }

        if($admin){
            if(empty(session('class_id'))){
                session(['class_id'=>'101']);
            }
        }

        $class_id=(session('class_id'))?session('class_id'):$tea_class['class_id'];

        //查該班送出訂單了沒，如果有，轉至edit
        $check_order = LunchStuOrder::where('semester', $semester)
            ->where('student_num', 'like',  $class_id.'%')
            ->first();

        if (!empty($check_order->id)) {
            return redirect()->route('lunch_students.edit');
        }else{
            return redirect()->route('lunch_students.create');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //目前是哪一個學期
        $semester = get_semester();

        //判斷是否為級任老師
        $tea_class = check_tea();

        //是否為管理者
        $admin = check_admin(3);

        if($tea_class['is_tea'] == "0" and $admin == "0"){
            $words = "你不是級任老師或管理員！";
            return view('layouts.error',compact('words'));
        }

        //查新學期設好了沒
        $check_new_semester = LunchOrderDate::where('semester','=',$semester)->first();
        if(empty($check_new_semester)){
            $words = "新學期尚未設定好！";
            return view('layouts.error',compact('words'));
        }

        $year_class = YearClass::where('semester','=',$semester)
            ->where('year_class','=',session('class_id'))
            ->first();


        if($year_class) {
            $class_name = $year_class->name;
            $year_class_id = $year_class->id;
            $class_id = $year_class->year_class;
            $is_tea = "1";
        }


        $stu_data=[];
        if($year_class_id){
            $stu_datas = SemesterStudent::where('year_class_id', '=', $year_class_id)
                ->where('at_school','=','1')
                ->orderBy('num')
                ->get();
            foreach ($stu_datas as $stu) {
                $stu_data[$stu->num]['name'] = $stu->student->name;
                $stu_data[$stu->num]['sex'] = $stu->student->sex;
                $stu_data[$stu->num]['id'] = $stu->student->id;
            }
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
        $order_id_array = get_lunch_order_array($semester);
        //key value 互換
        $order_array_id = array_flip($order_id_array);

        //每個餐期供餐情況
        $order_dates = get_lunch_order_dates($semester);


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
                    $att['lunch_order_id'] = $order_array_id[substr($k, 0, 7)];
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
    public function edit()
    {
        //目前是哪一個學期
        $semester = get_semester();

        //是否為管理者
        $admin = check_admin(3);

        $stu_datas = LunchStuOrder::where('semester','=',$semester)
            ->where('student_num','like',session('class_id').'%')
            ->orderBy('student_num')
            ->get();
        foreach($stu_datas as $stu){
            $stu_data[substr($stu->student_num,3,2)]['name'] = $stu->student->name;
            $stu_data[substr($stu->student_num,3,2)]['sex'] = $stu->student->sex;
            $stu_data[substr($stu->student_num,3,2)]['id'] = $stu->student->id;
            $stu_data[substr($stu->student_num,3,2)]['out_in'] = $stu->out_in;
        }

        $class_orders = LunchStuOrder::where('semester','=',$semester)
            ->where('student_num','like',session('class_id').'%')
            ->orderBy('student_num')
            ->get();
        foreach($class_orders as $class_order){
            $order_data[$class_order->student_id]['eat_style'] = $class_order->eat_style;
            $order_data[$class_order->student_id]['p_id'] = $class_order->p_id;
            $order_data[$class_order->student_id]['enable'] = $class_order->enable;
        }

        $data = [
            'semester'=>$semester,
            'admin'=>$admin,
            'class_id'=>session('class_id'),
            'stu_data'=>$stu_data,
            'order_data'=>$order_data,
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

    public function change_tea(Request $request)
    {
        $admin = check_admin(3);
        if($admin){
            session(['class_id' => $request->input('class_id')]);

            if($request->input('page') == "order"){
                return redirect()->route('lunch_students.index');
            }
            if($request->input('page') == "back"){
                return redirect()->route('lunch_students.back');
            }
        }

    }

    public function back()
    {
        //目前是哪一個學期
        $semester = get_semester();

        //是否為管理者
        $admin = check_admin(3);

        //判斷是否為級任老師
        $tea_class = check_tea();

        //查新學期設好了沒
        $check_new_semester = LunchOrderDate::where('semester','=',$semester)->first();
        if(empty($check_new_semester)){
            $words = "新學期尚未設定好！";
            return view('layouts.error',compact('words'));
        }


        if($tea_class['is_tea'] == "0" and $admin == "0"){
            $words = "你不是級任老師或管理員！";
            return view('layouts.error',compact('words'));
        }


        $year_class = YearClass::where('semester','=',$semester)
            ->where('year_class','=',session('class_id'))
            ->first();


        if($year_class) {
            $class_id = $year_class->year_class;
            $is_tea = "1";
            session(['class_id' => $class_id]);
        }else{
            $class_id = "";
            $is_tea = "0";
            //session(['class_id' => null]);
        }

        if($is_tea == "0" and $admin == "0"){
            $words = "你不是級任老師或管理員！";
            return view('layouts.error',compact('words'));
        }

        //是否停止學生退餐了
        $setup = LunchSetup::where('semester',$semester)
        ->first();

        if(!$setup){
            $words = "新學期尚未設定好！";
            return view('layouts.error',compact('words'));
        }

        //餐期選單
        $order_id_array = [];
        $array_order_id=[];
        $orders = LunchOrder::where('semester','=',$semester)->orderBy('id')->get();
        foreach($orders as $order){
            $order_id_array[$order->id] =$order->name;
            $array_order_id[$order->name] = $order->id;
        }

        //選取月份
        $order_id = (empty(Input::get('select_order_id')))?$array_order_id[date('Y-m')]:Input::get('select_order_id');

        //學生訂餐資料
        $stu_data=[];
        $cancel_stus=[];
        $stu_datas = LunchStuOrder::where('semester','=',$semester)
            ->where('student_num','like',$class_id.'%')
            ->orderBy('student_num')
            ->get();
        foreach($stu_datas as $stu){
            $stu_data[substr($stu->student_num,3,2)]['name'] = $stu->student->name;
            $stu_data[substr($stu->student_num,3,2)]['sex'] = $stu->student->sex;
            $stu_data[substr($stu->student_num,3,2)]['id'] = $stu->student->id;
            $stu_data[substr($stu->student_num,3,2)]['out_in'] = $stu->out_in;
            $cancel_stus[$stu->student->id] = substr($stu->student_num,3,2) ." ".$stu->student->name;
        }


        //學生該月的訂餐資料
        $order_dates=[];
        $order_dates = LunchStuDate::where('semester',$semester)
            ->where('class_id',$class_id)
            ->where('lunch_order_id',$order_id)
            ->orderBy('num')
            ->get();
        $order_data=[];
        foreach($order_dates as $order_date){
            $order_data[$order_date->student_id][$order_date->order_date]['id'] = $order_date->id;
            $order_data[$order_date->student_id][$order_date->order_date]['num'] = $order_date->num;
            $order_data[$order_date->student_id][$order_date->order_date]['name'] = $order_date->student->name;
            $order_data[$order_date->student_id][$order_date->order_date]['eat_style'] = $order_date->eat_style;
            $order_data[$order_date->student_id][$order_date->order_date]['enable'] = $order_date->enable;
            $order_data[$order_date->student_id][$order_date->order_date]['p_id'] = $order_date->p_id;
        }

        //此月份的供餐日
        $order_dates=[];
        $cancel_dates=[];
        $order_dates = LunchOrderDate::where('lunch_order_id',$order_id)
            ->where('enable','1')
            ->orderBy('order_date')
            ->get();
        foreach($order_dates as $order_date){
            $cancel_dates[$order_date->order_date] = $order_date->order_date;
        }

        $data = [
            'class_id'=>$class_id,
            'admin'=>$admin,
            'order_id_array'=>$order_id_array,
            'order_id'=>$order_id,
            'stu_data'=>$stu_data,
            'order_data'=>$order_data,
            'order_dates'=>$order_dates,
            'cancel_stus'=>$cancel_stus,
            'cancel_dates'=>$cancel_dates,
        ];
        return view('lunch_students.back',$data);
    }

    public function cancel_stu(Request $request)
    {
        $student_id = $request->input('cancel_stu');
        $order_date = $request->input('cancel_date');

        //目前是哪一個學期
        $semester = get_semester();

        //是否停止學生退餐了
        $setup = LunchSetup::where('semester',$semester)
            ->first();
        if($setup->disable == "1") {
            $words = "本學期學生已停止退餐！！";
            return view('layouts.error', compact('words'));
        }


        //最後停止日期
        $lunch_setup = LunchSetup::where('semester',$semester)->first();
        $die_line = $lunch_setup->die_line;
        $dt = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->addDays($die_line)->toDateTimeString();
        $die_date = str_replace('-','',substr($dt,0,10));
        if(str_replace('-','',$order_date) < $die_date){
            $words = "該日已無法取消訂餐！";
            return view('layouts.error',compact('words'));
        }


        $stu_order = LunchStuDate::where('student_id',$student_id)
            ->where('order_date',$order_date)
            ->first();
        if($stu_order->enable == "eat"){
            $att['enable'] = "abs";//請假退餐
            $stu_order->update($att);
        }

        return redirect()->route('lunch_students.back');
    }

    public function reback(LunchStuDate $lunch_stu_date)
    {
        $att['enable'] = "eat";
        $lunch_stu_date->update($att);
        return redirect()->route('lunch_students.back');

    }

    public function check()
    {
        //目前是哪一個學期
        $semester = get_semester();

        //是否為管理者
        $admin = check_admin(3);

        //判斷是否為級任老師
        $tea_class = check_tea();

        if($tea_class['is_tea'] == "0" and $admin == "0"){
            $words = "你不是級任老師或管理員！";
            return view('layouts.error',compact('words'));
        }

        //查新學期設好了沒
        $check_new_semester = LunchOrderDate::where('semester','=',$semester)->first();
        if(empty($check_new_semester)){
            $words = "新學期尚未設定好！";
            return view('layouts.error',compact('words'));
        }

        $lunch_order_dates = get_lunch_order_dates($semester);

        foreach($lunch_order_dates as $k=>$v){
            if($v == 1){
                $order_dates[$k] = $k;
            }
        }

        $checks=[];
        $checks = LunchCheck::where('semester','=',$semester)
            ->where('user_id','=',auth()->user()->id)
            ->where('class_id','=',session('class_id'))
            ->orderBy('order_date','DESC')
            ->get();

        $admin_checks = [];
        if($admin) {
            $admin_checks = LunchCheck::where('semester', '=', $semester)
                ->orderBy('class_id')
                ->orderBy('order_date', 'DESC')
                ->get();
        }

        $data = [
            'semester' => $semester,
            'class_id' =>session('class_id'),
            'admin' =>$admin,
            'order_dates'=>$order_dates,
            'checks'=>$checks,
            'admin_checks'=>$admin_checks,
        ];

        return view('lunch_students.check',$data);
    }

    public function check_store(Request $request)
    {

        if(empty($request->input('main_eat'))){
            $att['main_eat'] = 1 ;
        }
        if(empty($request->input('main_vag'))){
            $att['main_vag'] = 1 ;
        }
        if(empty($request->input('co_vag'))){
            $att['co_vag'] = 1 ;
        }
        if(empty($request->input('vag'))){
            $att['vag'] = 1 ;
        }
        if(empty($request->input('soup'))){
            $att['soup'] = 1 ;
        }

        if(empty($att)){
            $words = "每一項都合格不用回報！";
            return view('layouts.error',compact('words'));
        }

        if(empty($request->input('reason') )){
            $words = "請輸入不合格原因！";
            return view('layouts.error',compact('words'));
        }

        //取該日的資訊
        $dates=[];
        $lunch_order_dates = LunchOrderDate::where('semester','=',$request->input('semester'))->get();
        if($lunch_order_dates) {
            foreach ($lunch_order_dates as $v) {
                $dates[$v->order_date] = $v->enable;
            }
        }

        if($dates[$request->input('order_date')] != "1"){
            $words = $request->input('order_date') . " 該日沒有供餐！";
            return view('layouts.error',compact('words'));
        }

        $check = LunchCheck::where('class_id','=',$request->input('class_id'))
            ->where('order_date','=',$request->input('order_date'))
            ->first();
        if(!empty($check)){
            $words = $request->input('order_date') . " 該日已回報過！";
            return view('layouts.error',compact('words'));
        }


        $att['order_date'] = $request->input('order_date');
        $att['reason'] = $request->input('reason');
        $att['action'] = $request->input('action');
        $att['semester'] = $request->input('semester');
        $att['class_id'] = $request->input('class_id');
        $att['user_id'] = $request->input('user_id');

        LunchCheck::create($att);
        return redirect()->route('lunch_checks.index');
    }

    public function check_destroy(LunchCheck $check)
    {
        $check->delete();
        return redirect()->route('lunch_checks.index');
    }

    public function check_print()
    {
        //目前是哪一個學期
        $semester = get_semester();
        $admin_checks = LunchCheck::where('semester', '=', $semester)
            ->orderBy('class_id')
            ->orderBy('order_date', 'DESC')
            ->get();

        $data = [
            'admin_checks'=>$admin_checks,
            'semester'=>$semester,
        ];
        return view('lunch_students.check_print',$data);
    }

    public function satisfaction()
    {
        //目前是哪一個學期
        $semester = get_semester();

        //是否為管理者
        $admin = check_admin(3);

        //判斷是否為級任老師
        $tea_class = check_tea();

        if($tea_class['is_tea'] == "0" and $admin == "0"){
            $words = "你不是級任老師或管理員！";
            return view('layouts.error',compact('words'));
        }


        $satisfactions = LunchSatisfaction::all();

        $data = [
            'admin' =>$admin,
            'class_id' =>session('class_id'),
            'semester' => $semester,
            'satisfactions' => $satisfactions,
        ];
        return view('lunch_students.satisfaction',$data);
    }

    public function satisfaction_store(Request $request)
    {
        LunchSatisfaction::create($request->all());
        return redirect()->route('lunch_satisfactions.index');
    }

    public function satisfaction_destroy(LunchSatisfaction $satisfaction)
    {
        LunchSatisfactionClass::where('lunch_satisfaction_id','=',$satisfaction->id)
            ->delete();
        $satisfaction->delete();
        return redirect()->route('lunch_satisfactions.index');
    }

    public function satisfaction_show(LunchSatisfaction $satisfaction)
    {

        //判斷是否為級任老師
        $tea_class = check_tea();

        if($tea_class['is_tea'] == "0"){
            $words = "你不是級任老師！";
            return view('layouts.error',compact('words'));
        }

        $student_people = LunchStuOrder::where('semester','=',$satisfaction->semester)
            ->where('student_num','like',$tea_class['class_id'].'%')
            ->where('eat_style','!=','3')
            ->count();

        $tea = LunchTeaDate::where('semester','=',$satisfaction->semester)
            ->where('user_id','=',auth()->user()->id)
            ->where('enable','=','eat')
            ->first();
        if(!empty($tea)){
            $tea_people = 1;
        }else{
            $tea_people = 0;
        }

        $class_people = $student_people + $tea_people;

        $data = [
            'satisfaction'=>$satisfaction,
            'class_id' =>$tea_class['class_id'],
            'class_people'=>$class_people,
        ];
        return view('lunch_students.satisfaction_show',$data);
    }

    public function satisfaction_show_store(Request $request)
    {
        $has_done = LunchSatisfactionClass::where('lunch_satisfaction_id','=',$request->input('lunch_satisfaction_id'))
            ->where('class_id','=',$request->input('class_id'))
            ->count();

        if($has_done > 0){
            $words = "該班填寫過了！";
            return view('layouts.error',compact('words'));
        }

        LunchSatisfactionClass::create($request->all());
        return redirect()->route('lunch_satisfactions.index');
    }

    public function satisfaction_show_answer(LunchSatisfaction $satisfaction)
    {

        //判斷是否為級任老師
        $tea_class = check_tea();

        if($tea_class['is_tea'] == "0"){
            $words = "你不是級任老師！";
            return view('layouts.error',compact('words'));
        }

        $satisfaction_class = LunchSatisfactionClass::where('lunch_satisfaction_id','=',$satisfaction->id)
            ->where('class_id','=',$tea_class['class_id'])
            ->first();

        $total =
            $satisfaction_class->q1_1+
            $satisfaction_class->q1_2+
            $satisfaction_class->q1_3+
            $satisfaction_class->q1_4+
            $satisfaction_class->q1_5+
            $satisfaction_class->q2_1+
            $satisfaction_class->q2_2+
            $satisfaction_class->q3_1+
            $satisfaction_class->q3_2+
            $satisfaction_class->q3_3+
            $satisfaction_class->q3_4+
            $satisfaction_class->q3_5+
            $satisfaction_class->q3_6+
            $satisfaction_class->q3_7+
            $satisfaction_class->q3_8+
            $satisfaction_class->q3_9+
            $satisfaction_class->q3_10+
            $satisfaction_class->q4_1+
            $satisfaction_class->q4_2;

        $data = [
            'satisfaction_class'=>$satisfaction_class,
            'total'=>$total,
        ];
        return view('lunch_students.satisfaction_show_answer',$data);
    }

    public function satisfaction_help(LunchSatisfaction $satisfaction){
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }

        $satisfaction_class_data = LunchSatisfactionClass::where('lunch_satisfaction_id','=',$satisfaction->id)->get();
        foreach($satisfaction_class_data as $s_c){
            $has_done[$s_c->class_id] = 1;
        }


        $classes = YearClass::where('semester','=',$satisfaction->semester)->get();
        foreach($classes as $class_data){
            if(!isset($has_done[$class_data->year_class])){
                $student_people = LunchStuOrder::where('semester','=',$satisfaction->semester)
                    ->where('student_num','like',$class_data->year_class.'%')
                    ->where('eat_style','!=','3')
                    ->count();

                $tea = LunchTeaDate::where('semester','=',$satisfaction->semester)
                    ->where('user_id','=',$class_data->user_id)
                    ->where('enable','=','eat')
                    ->first();
                if(!empty($tea)){
                    $tea_people = 1;
                }else{
                    $tea_people = 0;
                }

                $class_people = $student_people + $tea_people;

                $att['class_people'] = $class_people;
                $att['q1_1'] = "3";
                $att['q1_2'] = "3";
                $att['q1_3'] = "3";
                $att['q1_4'] = "3";
                $att['q1_5'] = "3";
                $att['q2_1'] = "7";
                $att['q2_2'] = "7";
                $att['q3_1'] = "6";
                $att['q3_2'] = "6";
                $att['q3_3'] = "6";
                $att['q3_4'] = "6";
                $att['q3_5'] = "6";
                $att['q3_6'] = "6";
                $att['q3_7'] = "6";
                $att['q3_8'] = "6";
                $att['q3_9'] = "6";
                $att['q3_10'] = "6";
                $att['q4_1'] = "5";
                $att['q4_2'] = "6";
                $att['class_id'] = $class_data->year_class;
                $att['user_id'] = $class_data->user_id;
                $att['lunch_satisfaction_id'] = $satisfaction->id;
                LunchSatisfactionClass::create($att);
            }
        }

        return redirect()->route('lunch_satisfactions.index');

    }

    public function satisfaction_print($id){
        $satisfaction_classes_data = LunchSatisfactionClass::where('lunch_satisfaction_id','=',$id)
            ->orderBy('class_id')
            ->get();
        $favority = "";
        $suggest = "";
        foreach($satisfaction_classes_data as $satisfaction_class_data){
            $class_data[$satisfaction_class_data->class_id]['semester'] = $satisfaction_class_data->lunch_satisfaction->semester;
            $class_data[$satisfaction_class_data->class_id]['class_id'] = $satisfaction_class_data->class_id;
            $class_data[$satisfaction_class_data->class_id]['class_people'] = $satisfaction_class_data->class_people;
            $class_data[$satisfaction_class_data->class_id]['q1_1'] = $satisfaction_class_data->q1_1;
            $class_data[$satisfaction_class_data->class_id]['q1_2'] = $satisfaction_class_data->q1_2;
            $class_data[$satisfaction_class_data->class_id]['q1_3'] = $satisfaction_class_data->q1_3;
            $class_data[$satisfaction_class_data->class_id]['q1_4'] = $satisfaction_class_data->q1_4;
            $class_data[$satisfaction_class_data->class_id]['q1_5'] = $satisfaction_class_data->q1_5;
            $class_data[$satisfaction_class_data->class_id]['q2_1'] = $satisfaction_class_data->q2_1;
            $class_data[$satisfaction_class_data->class_id]['q2_2'] = $satisfaction_class_data->q2_2;
            $class_data[$satisfaction_class_data->class_id]['q3_1'] = $satisfaction_class_data->q3_1;
            $class_data[$satisfaction_class_data->class_id]['q3_2'] = $satisfaction_class_data->q3_2;
            $class_data[$satisfaction_class_data->class_id]['q3_3'] = $satisfaction_class_data->q3_3;
            $class_data[$satisfaction_class_data->class_id]['q3_4'] = $satisfaction_class_data->q3_4;
            $class_data[$satisfaction_class_data->class_id]['q3_5'] = $satisfaction_class_data->q3_5;
            $class_data[$satisfaction_class_data->class_id]['q3_6'] = $satisfaction_class_data->q3_6;
            $class_data[$satisfaction_class_data->class_id]['q3_7'] = $satisfaction_class_data->q3_7;
            $class_data[$satisfaction_class_data->class_id]['q3_8'] = $satisfaction_class_data->q3_8;
            $class_data[$satisfaction_class_data->class_id]['q3_9'] = $satisfaction_class_data->q3_9;
            $class_data[$satisfaction_class_data->class_id]['q3_10'] = $satisfaction_class_data->q3_10;
            $class_data[$satisfaction_class_data->class_id]['q4_1'] = $satisfaction_class_data->q4_1;
            $class_data[$satisfaction_class_data->class_id]['q4_2'] = $satisfaction_class_data->q4_2;
            $class_data[$satisfaction_class_data->class_id]['total'] =
                $class_data[$satisfaction_class_data->class_id]['q1_1']+
                $class_data[$satisfaction_class_data->class_id]['q1_2']+
                $class_data[$satisfaction_class_data->class_id]['q1_3']+
                $class_data[$satisfaction_class_data->class_id]['q1_4']+
                $class_data[$satisfaction_class_data->class_id]['q1_5']+
                $class_data[$satisfaction_class_data->class_id]['q2_1']+
                $class_data[$satisfaction_class_data->class_id]['q2_2']+
                $class_data[$satisfaction_class_data->class_id]['q3_1']+
                $class_data[$satisfaction_class_data->class_id]['q3_2']+
                $class_data[$satisfaction_class_data->class_id]['q3_3']+
                $class_data[$satisfaction_class_data->class_id]['q3_4']+
                $class_data[$satisfaction_class_data->class_id]['q3_5']+
                $class_data[$satisfaction_class_data->class_id]['q3_6']+
                $class_data[$satisfaction_class_data->class_id]['q3_7']+
                $class_data[$satisfaction_class_data->class_id]['q3_8']+
                $class_data[$satisfaction_class_data->class_id]['q3_9']+
                $class_data[$satisfaction_class_data->class_id]['q3_10']+
                $class_data[$satisfaction_class_data->class_id]['q4_1']+
                $class_data[$satisfaction_class_data->class_id]['q4_2'];
            $class_data[$satisfaction_class_data->class_id]['favority'] = $satisfaction_class_data->favority;
            if(!empty($satisfaction_class_data->favority))  $favority .= $satisfaction_class_data->favority."<br>";
            $class_data[$satisfaction_class_data->class_id]['suggest'] = $satisfaction_class_data->suggest;
            if(!empty($satisfaction_class_data->suggest)) $suggest .= $satisfaction_class_data->suggest."<br>";

            if(empty($satisfaction_class_data->user_id)){
                $class_data[$satisfaction_class_data->class_id]['teacher'] = "";
            }else{
                $class_data[$satisfaction_class_data->class_id]['teacher'] = $satisfaction_class_data->user->name;
            }
            $semester = $satisfaction_class_data->lunch_satisfaction->semester;
        }
        $data =[
            'class_data'=>$class_data,
            'semester' =>$semester,
            'favority' => $favority,
            'suggest' => $suggest,
        ];

        return view('lunch_students.satisfaction_show_print',$data);
    }
}

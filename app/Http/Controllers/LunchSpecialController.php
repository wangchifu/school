<?php

namespace App\Http\Controllers;

use App\LunchStuDate;
use App\LunchStuOrder;
use App\LunchTeaDate;
use App\SemesterStudent;
use App\Student;
use App\YearClass;
use Illuminate\Http\Request;

class LunchSpecialController extends Controller
{

    public function fill_tea()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }

        return view('lunch_specials.fill_tea');
    }

    public function change_tea()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }
        //目前是哪一個學期
        $semester = get_semester();
        $tea_dates = LunchTeaDate::where('semester',$semester)
            ->where('enable','1')
            ->get();
        //教師選單
        $teachers=[];
        foreach($tea_dates as $tea_date){
            $teachers[$tea_date->user_id] = $tea_date->user->name;
        }
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'teachers'=>$teachers,
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.change_tea',$data);
    }

    public function change_tea_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();
        $user_id = $request->input('user_id');
        $order_date = $request->input('order_date');
        $att['eat_style'] = $request->input('eat_style');
        $tea_dates = LunchTeaDate::where('semester',$semester)
            ->where('user_id',$user_id)
            ->where('order_date','>=',$order_date)
            ->get();
        foreach($tea_dates as $tea_date){
            $tea_date->update($att);
        }
        return redirect()->route('lunch_specials.change_tea');
    }

    public function back_tea()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }

        //目前是哪一個學期
        $semester = get_semester();
        $tea_dates = LunchTeaDate::where('semester',$semester)
            ->where('enable','1')
            ->get();
        //教師選單
        $teachers=[];
        foreach($tea_dates as $tea_date){
            $teachers[$tea_date->user_id] = $tea_date->user->name;
        }
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'teachers'=>$teachers,
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.back_tea',$data);
    }

    public function back_tea_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();
        $user_id = $request->input('user_id');
        $order_date = $request->input('order_date');
        $att['enable'] = 0;
        $tea_date = LunchTeaDate::where('semester',$semester)
            ->where('user_id',$user_id)
            ->where('order_date',$order_date)
            ->first();

        $tea_date->update($att);
        return redirect()->route('lunch_specials.back_tea');
    }

    public function change_stu_begin()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }

        return view('lunch_specials.change_stu_begin');
    }

    public function change_stu_begin_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();
        $class_num = $request->input('class_num');
        $select_class = substr($class_num,0,3);
        $year_class = YearClass::where('semester',$semester)
            ->where('year_class',$select_class)
            ->first();
        $year_class_id = $year_class->id;
        $this_student = SemesterStudent::where('year_class_id',$year_class_id)
            ->where('num',substr($class_num,3,2))
            ->first();
        $student_id = $this_student->student_id;
        $att['eat_style'] = $request->input('eat_style');
        $att['p_id'] = $request->input('p_id');
        LunchStuOrder::where('semester',$semester)
            ->where('student_id',$student_id)
            ->update($att);
        LunchStuDate::where('semester',$semester)
            ->where('student_id',$student_id)
            ->update($att);

        return redirect()->route('lunch_specials.change_stu_begin');

    }

    public function change_one_stu()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        //目前是哪一個學期
        $semester = get_semester();
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.change_one_stu',$data);
    }

    public function change_one_stu_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        $order_date = $request->input('order_date');

        $class_num = $request->input('class_num');
        $select_class = substr($class_num,0,3);
        $year_class = YearClass::where('semester',$semester)
            ->where('year_class',$select_class)
            ->first();
        $year_class_id = $year_class->id;
        $this_student = SemesterStudent::where('year_class_id',$year_class_id)
            ->where('num',substr($class_num,3,2))
            ->first();
        $student_id = $this_student->student_id;
        $att['eat_style'] = $request->input('eat_style');

        LunchStuDate::where('semester',$semester)
            ->where('student_id',$student_id)
            ->where('order_date','>=',$order_date)
            ->update($att);

        return redirect()->route('lunch_specials.change_one_stu');
    }

    public function back_one_stu()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        //目前是哪一個學期
        $semester = get_semester();
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.back_one_stu',$data);
    }

    public function back_one_stu_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        $order_date = $request->input('order_date');

        $class_num = $request->input('class_num');
        $select_class = substr($class_num,0,3);
        $year_class = YearClass::where('semester',$semester)
            ->where('year_class',$select_class)
            ->first();
        $year_class_id = $year_class->id;
        $this_student = SemesterStudent::where('year_class_id',$year_class_id)
            ->where('num',substr($class_num,3,2))
            ->first();
        $student_id = $this_student->student_id;
        $att['enable'] = $request->input('enable');

        LunchStuDate::where('semester',$semester)
            ->where('student_id',$student_id)
            ->where('order_date','=',$order_date)
            ->update($att);

        return redirect()->route('lunch_specials.back_one_stu');
    }

    public function back_one_class()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        //目前是哪一個學期
        $semester = get_semester();
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.back_one_class',$data);
    }

    public function back_one_class_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        $order_date = $request->input('order_date');
        $class_id = $request->input('class_id');

        $att['enable'] = "abs";
        LunchStuDate::where('semester',$semester)
            ->where('class_id',$class_id)
            ->where('order_date','=',$order_date)
            ->where('enable','eat')
            ->update($att);

        return redirect()->route('lunch_specials.back_one_class');
    }

    public function back_one_year()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        //目前是哪一個學期
        $semester = get_semester();
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.back_one_year',$data);
    }

    public function back_one_year_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        $order_date = $request->input('order_date');
        $year = $request->input('year');

        $att['enable'] = "abs";
        LunchStuDate::where('semester',$semester)
            ->where('class_id','like',$year."%")
            ->where('order_date','=',$order_date)
            ->where('enable','eat')
            ->update($att);

        return redirect()->route('lunch_specials.back_one_year');
    }

    public function back_one_year_no_money()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        //目前是哪一個學期
        $semester = get_semester();
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.back_one_year_no_money',$data);
    }

    public function back_one_year_no_money_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        $order_date = $request->input('order_date');
        $year = $request->input('year');

        $att['enable'] = "not_in";
        LunchStuDate::where('semester',$semester)
            ->where('class_id','like',$year."%")
            ->where('order_date','=',$order_date)
            ->where('enable','eat')
            ->update($att);

        return redirect()->route('lunch_specials.back_one_year_no_money');
    }

    public function back_all_school()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        //目前是哪一個學期
        $semester = get_semester();
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.back_all_school',$data);
    }

    public function back_all_school_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        $order_date = $request->input('order_date');

        $att1['enable'] = "0";
        $att2['enable'] = "abs";
        LunchTeaDate::where('semester',$semester)
        ->where('order_date','=',$order_date)
        ->where('enable','1')
        ->update($att1);

        LunchStuDate::where('semester',$semester)
            ->where('order_date','=',$order_date)
            ->where('enable','eat')
            ->update($att2);

        return redirect()->route('lunch_specials.back_all_school');
    }

    public function out_stu()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        //目前是哪一個學期
        $semester = get_semester();
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.out_stu',$data);
    }

    public function out_stu_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        $order_date = $request->input('order_date');

        $class_num = $request->input('class_num');
        $select_class = substr($class_num,0,3);
        $year_class = YearClass::where('semester',$semester)
            ->where('year_class',$select_class)
            ->first();
        $year_class_id = $year_class->id;
        $this_student = SemesterStudent::where('year_class_id',$year_class_id)
            ->where('num',substr($class_num,3,2))
            ->first();
        $student_id = $this_student->student_id;

        //學期轉出
        $semester_student = SemesterStudent::where('semester',$semester)
            ->where('student_id',$student_id)->first();
        $att['at_school'] = "0";
        $semester_student->update($att);

        //處理午餐
        $stu_order = LunchStuOrder::where('semester',$semester)
            ->where('student_id',$student_id)
            ->first();
        $att2['p_id'] = "99".$stu_order->p_id;
        $att2['enable'] = "abs";
        LunchStuDate::where('semester',$semester)
            ->where('student_id',$student_id)
            ->where('order_date','>=',$order_date)
            ->update($att2);

        //轉出標記
        $att3['out_in'] = "out";
        $att3['change_date'] = $order_date;
        $stu_order = LunchStuOrder::where('semester',$semester)
            ->where('student_id',$student_id)
            ->first();
        $stu_order->update($att3);


        return redirect()->route('lunch_specials.out_stu');
    }

    public function in_stu()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        //目前是哪一個學期
        $semester = get_semester();
        //供餐日期
        $lunch_order_dates = get_lunch_order_dates($semester);
        $date_data=[];
        foreach($lunch_order_dates as $k=>$v){
            if($v==1){
                $date_data[$k] = $k;
            }
        }

        $data = [
            'date_data'=>$date_data,
        ];
        return view('lunch_specials.in_stu',$data);
    }

    public function in_stu_store(Request $request)
    {
        //目前是哪一個學期
        $semester = get_semester();

        $order_date = $request->input('order_date');

        //班級代碼
        $year_class = YearClass::where('semester',$semester)
            ->where('year_class',substr($request->input('class_num'),0,3))
            ->first();

        //查有學生資料嗎
        $student = Student::where('sn', '=', $request->input('sn'))
            ->first();
        if (!empty($student)) {
            //有無學期資料了
            $semester_student = SemesterStudent::where('semester', '=', $semester)
                ->where('student_id', '=', $student->id)
                ->first();
            //若無，就新增學期資料
            if (empty($semester_student)) {
                $att['semester'] = $semester;
                $att['student_id'] = $student->id;
                $att['year_class_id'] = $year_class->id;
                $att['num'] = substr($request->input('class_num'), 3, 2);
                $att['at_school'] = "1";
                SemesterStudent::create($att);
            }
            $student_id = $student->id;

        } else {
            //沒學生資料，就增加
            $att2['sn'] = $request->input('sn');
            $att2['name'] = $request->input('name');
            $att2['sex'] = $request->input('sex');
            //新增學生
            $add_student = Student::create($att2);

            //新增此學期資料
            $att3['semester'] = $semester;
            $att3['student_id'] = $add_student->id;
            $att3['year_class_id'] = $year_class->id;
            $att3['num'] = substr($request->input('class_num'), 3, 2);
            $att3['at_school'] = "1";
            SemesterStudent::create($att3);
            $student_id = $add_student->id;
        }

        //新增訂餐資料
        $order_dates = get_lunch_order_dates($semester);
        $order_id_array = get_lunch_order_array($semester);
        $order_array_id = array_flip($order_id_array);

        $att4['semester'] = $semester;
        $att4['student_id'] = $student_id;
        $att4['student_num'] = $request->input('class_num');
        $att4['eat_style'] = $request->input('eat_style');
        $att4['p_id'] = $request->input('p_id');
        $att4['out_in'] = "in";
        $att4['change_date'] = $order_date;
        LunchStuOrder::create($att4);

        foreach($order_dates as $k=>$v){
            $att5['order_date'] = $k;

            if($v==0){
                $att5['enable'] = "not";
            }elseif($v==1){
                if($k < $order_date){
                    $att5['enable'] = "no_eat";
                }else{
                    $att5['enable'] = "eat";
                }
            }

            $att5['semester'] = $semester;
            $att5['lunch_order_id'] = $order_array_id[substr($k,0,7)];
            $att5['student_id'] = $student_id;
            $att5['class_id'] = substr($request->input('class_num'),0,3);
            $att5['num'] = substr($request->input('class_num'),3,2);
            $att5['eat_style'] = $request->input('eat_style');
            $att5['p_id'] = $request->input('p_id');

            LunchStuDate::create($att5);
        }
        return redirect()->route('lunch_specials.in_stu');
    }

    public function num_stu()
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        return view('lunch_specials.num_stu');
    }

    public function num_stu_store(Request $request)
    {
        //是否為管理者
        $admin = check_admin(3);
        if($admin == "0"){
            $words = "你不是管理員！";
            return view('layouts.error',compact('words'));
        }


        //目前是哪一個學期
        $semester = get_semester();
        $sn = $request->input('sn');
        $student_num = $request->input('student_num');
        $name = $request->input('name');

        $student = Student::where('sn',$sn)
            ->where('name',$name)
            ->first();


        if(!empty($student->id)){
            $student_id = $student->id;
            $att1['num'] = substr($student_num,3,2);
            SemesterStudent::where('semester',$semester)
                ->where('student_id',$student_id)
                ->update($att1);

            $att2['student_num'] = $student_num;
            LunchStuOrder::where('semester',$semester)
                ->where('student_id',$student_id)
                ->update($att2);

            $att3['num'] = substr($student_num,3,2);
            LunchStuDate::where('semester',$semester)
                ->where('student_id',$student_id)
                ->update($att3);

        }else{
            $words = "查無此人！";
            return view('layouts.error',compact('words'));
        }

        return redirect()->route('lunch_specials.num_stu');

    }
}

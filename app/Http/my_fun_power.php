<?php
///////////////////4.權限相關///////////////////////////////
//檢查是不是該模組的管理者
if(! function_exists('check_admin')){
    function check_admin($type){
        $check_admin = \App\Fun::where('user_id',auth()->user()->id)
            ->where('type',$type)
            ->first();
        return $admin = (empty($check_admin))?0:1;

    }
}

//檢查當今學期，登入者是不是班級導師
if(! function_exists('check_tea')){
    function check_tea(){
        $semester = get_semester();
        $year_class = \App\YearClass::where('semester','=',$semester)
            ->where('user_id','=',auth()->user()->id)
            ->first();

        if($year_class) {
            $tea_class['is_tea'] = 1;
            $tea_class['class_name'] = $year_class->name;
            $tea_class['class_id'] = $year_class->year_class;
            session(['class_id'=>$year_class->year_class]);
        }else{
            $tea_class['is_tea'] = 0;
            $tea_class['class_name'] = "";
            $tea_class['class_id'] = "";
        }
        return $tea_class;
    }
}
<?php
///////////////////3.學期與班級相關///////////////////////////////
//指定學期的班級選單array
if(! function_exists('get_class_menu')){
    function get_class_menu($semester){
        $classes = \App\YearClass::where('semester',$semester)
            ->orderBy('year_class')
            ->pluck('year_class', 'year_class')->toArray();
        return $classes;
    }
}

//列出學期選單array
if(! function_exists('get_semester_menu')){
    function get_semester_menu(){
        $semesters = \App\YearClass::groupBy('semester')->pluck('semester','semester')->toArray();
        krsort($semesters);
        return $semesters;
    }
}

//秀某學期的每一天
if(! function_exists('get_semester_dates')){
    function get_semester_dates($semester)
    {
        $this_year = substr($semester,0,3)+1911;
        $this_seme = substr($semester,-1,1);
        $next_year = $this_year +1 ;
        if($this_seme == 1){
            $month_array = ["八月"=>$this_year."-08","九月"=>$this_year."-09","十月"=>$this_year."-10","十一月"=>$this_year."-11","十二月"=>$this_year."-12","一月"=>$next_year."-01"];
        }else{
            $month_array = ["二月"=>$next_year."-02","三月"=>$next_year."-03","四月"=>$next_year."-04","五月"=>$next_year."-05","六月"=>$next_year."-06"];
        }


        foreach($month_array as $k => $v) {
            $semester_dates[$k] = get_month_date($v);
        }
        return $semester_dates;
    }
}

if(! function_exists('back_cht_year_class')){
    //給3碼班級代號，傳回中文班級
    function back_cht_year_class($year_class)
    {
        $cht_year = [
            '1'=>'一年',
            '2'=>'二年',
            '3'=>'三年',
            '4'=>'四年',
            '5'=>'五年',
            '6'=>'六年',
        ];
        $cht_class = [
            '01'=>'一班',
            '02'=>'二班',
            '03'=>'三班',
            '04'=>'四班',
            '05'=>'五班',
            '06'=>'六班',
            '07'=>'七班',
            '08'=>'八班',
            '09'=>'九班',
            '10'=>'十班',
            '11'=>'十一班',
            '12'=>'十二班',
            '13'=>'十三班',
            '14'=>'十四班',
            '15'=>'十五班',
            '16'=>'十六班',
            '17'=>'十七班',
            '18'=>'十八班',
            '19'=>'十九班',
            '20'=>'二十班',
        ];

        $y = substr($year_class,0,1);
        $c = substr($year_class,1,2);
        $cht = $cht_year[$y].$cht_class[$c];
        return $cht;
    }
}
<?php

//補足中文字數
if (! function_exists('mb_str_pad')) {
    function mb_str_pad(
        $input,
        $pad_length,
        $pad_string=" ",
        $pad_style=STR_PAD_RIGHT,
        $encoding="UTF-8")
    {
        return str_pad(
            $input,
            strlen($input)-mb_strlen($input,$encoding)+$pad_length,
            $pad_string,
            $pad_style);
    }
}

//顯示某目錄下的檔案
if (! function_exists('get_files')) {
    function get_files($folder){
        $files = [];
        if (is_dir($folder)) {
            if ($handle = opendir($folder)) { //開啟現在的資料夾
                while (false !== ($file = readdir($handle))) {
                    //避免搜尋到的資料夾名稱是false,像是0
                    if ($file != "." && $file != ".." && $file != "title_image.png") {
                        //去除掉..跟.
                        array_push($files,$file);
                    }
                }
                closedir($handle);
            }
        }
        return $files;
    }
}

//顯示某目錄下的檔案
if (! function_exists('get_folders_files')) {
    function get_folders_files($folder){
        $folders_files = [];
        $i=0;
        $k=0;
        if (is_dir($folder)) {
            if ($handle = opendir($folder)) { //開啟現在的資料夾
                while (false !== ($name = readdir($handle))) {
                    //避免搜尋到的資料夾名稱是false,像是0
                    if ($name != "." && $name != "..") {
                        //去除掉..跟.
                        if(is_dir($folder."/".$name)){
                            $folders_files['folders'][$i] = $name;
                            $i++;
                        }else{
                            $folders_files['files'][$k] = $name;
                            $k++;
                        }
                    }
                }
                closedir($handle);
            }
        }
        return $folders_files;
    }
}

if(! function_exists('filesizekb')) {
    function filesizekb($file)
    {
        return number_format(filesize($file) / pow(1024, 1), 2, '.', '');
    }
}


//查某日為星期幾
if(! function_exists('get_chinese_weekday')){
    function get_chinese_weekday($datetime)
    {
        $weekday = date('w', strtotime($datetime));
        return '星期' . ['日', '一', '二', '三', '四', '五', '六'][$weekday];
    }
}

//查目前日期為哪一個學期
if(! function_exists('get_semester')){
    function get_semester()
    {
        //查目前學期
        $y = (int)date('Y') - 1911;
        $array1 = array(8, 9, 10, 11, 12, 1);
        $array2 = array(2, 3, 4, 5, 6, 7);
        if (in_array(date('n'), $array1)) {
            if (date('n') == 1) {
                $this_semester = ($y - 1) . "1";
            } else {
                $this_semester = $y . "1";
            }
        } else {
            $this_semester = ($y - 1) . "2";
        }

        return $this_semester;

    }
}

//查指定日期為哪一個學期
if(! function_exists('get_date_semester')){
    function get_date_semester($date)
    {
        $d = explode('-',$date);
        //查目前學期
        $y = (int)$d[0] - 1911;
        $array1 = array(8, 9, 10, 11, 12, 1);
        $array2 = array(2, 3, 4, 5, 6, 7);
        if (in_array($d[1], $array1)) {
            if ($d[1] == 1) {
                $this_semester = ($y - 1) . "1";
            } else {
                $this_semester = $y . "1";
            }
        } else {
            $this_semester = ($y - 1) . "2";
        }

        return $this_semester;

    }
}

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


//檢查是不是該模組的管理者
if(! function_exists('check_admin')){
    function check_admin($type){
        $check_admin = \App\Fun::where('user_id',auth()->user()->id)
            ->where('type',$type)
            ->first();
        return $admin = (empty($check_admin))?"0":"1";

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

if(! function_exists('get_month_date')){
    //秀某年某月的每一天
    function get_month_date($year_month)
    {
        $this_date = explode("-",$year_month);
        $days=array("01"=>"31","02"=>"28","03"=>"31","04"=>"30","05"=>"31","06"=>"30","07"=>"31","08"=>"31","09"=>"30","10"=>"31","11"=>"30","12"=>"31");
        //潤年的話，二月29天
        if(checkdate(2,29,$this_date[0])){
            $days['02'] = 29;
        }else{
            $days['02'] = 28;
        }

        for($i=1;$i<= $days[$this_date[1]];$i++){
            $order_date[$i] = $this_date[0]."-".$this_date[1]."-".sprintf("%02s", $i);
        }
        return $order_date;
    }
}

//查某日星期幾
if(! function_exists('get_date_w')){
    function get_date_w($d)
    {
        $arrDate=explode("-",$d);
        $week=date("w",mktime(0,0,0,$arrDate[1],$arrDate[2],$arrDate[0]));
        return $week;
    }
}
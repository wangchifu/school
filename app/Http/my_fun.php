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
        $y = date('Y') - 1911;
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

//指定學期的班級選單array
if(! function_exists('get_class_menu')){
    function get_class_menu($semester){
        $classes = \App\YearClass::where('semester',$semester)
            ->orderBy('year_class')
            ->pluck('year_class', 'year_class')->toArray();
        return $classes;
    }
}

//檢查是不是該模組的管理者
if(! function_exists('check_admin')){
    function check_admin($type){
        $check_admin = \App\Fun::where('user_id',auth()->user()->id)
            ->where('type',$type)
            ->first();
        $admin = (empty($check_admin))?"0":"1";
        if($admin == "0"){
            $words = "你不是管理者！";
            return view('layouts.error',compact('words'));
        }else{
            return true;
        }
    }
}

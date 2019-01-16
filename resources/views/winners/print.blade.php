@extends('layouts.master_print')

@section('page-title', '填報獎狀名單')

@section('content')
    <?php
    $today = explode("-",date("Y-m-d"));
    $cht_year = $today[0]-1911;
    $cht_d = sprintf("%02s",$today[2]);
    $cht_day = "中華民國{$cht_year}年{$today[1]}月{$cht_d}日";
    $user = \App\User::where('job_title','校長')->first();
    $p = $user->name;

        $data = "";
        foreach($has_classes as $k1=>$v1){
            $year_class = back_cht_year_class($k1);
            foreach($lists as $k2=>$v2){
                if(isset($winners[$k1][$k2]['name'])){
                    $name = $winners[$k1][$k2]['name'];
                    $content = str_replace('{班級}',$year_class,$v2['description']);
                    $content = str_replace('{姓名}',$name,$content);
                    $content = str_replace('{換行}',"<br>",$content);
                    $data .= "
                <div style=\"font-family:標楷體;font-size:70px;margin-top:220px;margin-left:120px;margin-right:120px;line-height: 120px;position:relative;height:1230px;\">
                <br>
                " . $content ."
                <div style=\"font-family:標楷體;font-size:50px;position:absolute;bottom:130px;right:310px;\">校長</div>
                <div style=\"font-family:標楷體;font-size:90px;position:absolute;bottom:130px;right:0px;\">{$p}</div>
		        <div style=\"font-family:標楷體;font-size:30px;position:absolute;bottom:0px;right:0px;\">{$cht_day}　　　　</div>
		        </div>
		        <p style=\"page-break-after:always\"></p>
                ";
                }

            }
        }

        $data = substr($data,0,-42);

        echo $data;

    ?>

@endsection
@extends('layouts.master_print')

@section('page-title', '填報獎狀名單')

@section('content')
    <?php
    $today = explode("-",date("Y-m-d"));
    $cht_year = $today[0]-1911;
    $cht_d = sprintf("%02s",$today[2]);
    $cht_day = "中華民國{$cht_year}年{$today[1]}月{$cht_d}日";

        $data = "";
        foreach($has_classes as $k1=>$v1){
            $year_class = back_cht_year_class($k1);
            foreach($lists as $k2=>$v2){
                $name = $winners[$k1][$k2]['name'];
                $content = str_replace('{班級}',$year_class,$v2['description']);
                $content = str_replace('{姓名}',$name,$content);
                $data .= "
                <div style=\"font-family:標楷體;font-size:35px;margin-top:220px;margin-left:100px;\">
                " . $content ."
                <br>
		        <br>
		        <br>
		        <br>
		        <br>
		        <br>
		        <br>
		        <div style=\"font-family:標楷體;font-size:25px\" align=right>{$cht_day}　　</div>
		        </div>
		        <p style=\"page-break-after:always\"></p>
                ";
            }
        }

        echo $data;

    ?>

@endsection
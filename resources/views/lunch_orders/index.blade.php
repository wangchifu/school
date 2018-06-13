@extends('layouts.master')

@section('page-title', '午餐設定')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 供餐日設定</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item"><a href="{{ route('lunch_setups.index') }}">午餐設定</a></li>
            <li class="breadcrumb-item">供餐日設定</li>
        </ol>
    </nav>
    <br>
    @if($admin)
    <a href="{{ route('lunch_orders.store') }}" class="btn btn-success btn-sm"><i class="fas fa-save"></i> 儲存</a>
    <?php
        $today = \Carbon\Carbon::today();

        echo '<h1 class="w3-text-teal"><center>' . $today->format('F Y') . '</center></h1>';

        $tempDate = \Carbon\Carbon::createFromDate($today->year, $today->month, 1);



        echo '<table border="1" class = "w3-table w3-boarder w3-striped">
           <thead><tr class="w3-theme">
           <th>Sun</th>
           <th>Mon</th>
           <th>Tue</th>
           <th>Wed</th>
           <th>Thu</th>
           <th>Fri</th>
           <th>Sat</th>
           </tr></thead>';

        $skip = $tempDate->dayOfWeek;


        for($i = 0; $i < $skip; $i++)
        {
            $tempDate->subDay();
        }


        //loops through month
        do
        {
            echo '<tr>';
            //loops through each week
            for($i=0; $i < 7; $i++)
            {
                echo '<td><span class="date">';

                echo $tempDate->day;

                echo '</span></td>';

                $tempDate->addDay();
            }
            echo '</tr>';

        }while($tempDate->month == $today->month);

        echo '</table>';
    ?>



    @else
        <h1 class="text-danger">你不是管理者</h1>
    @endif
</div>
@endsection
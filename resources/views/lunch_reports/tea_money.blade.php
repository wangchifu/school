@extends('layouts.master')

@section('page-title', '教職收費單')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 教職收費單</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">報表輸出</li>
            <li class="breadcrumb-item active" aria-current="page">教職收費單</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['report'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    {{ Form::open(['route' => 'lunch_reports.tea_money', 'method' => 'POST']) }}
    請先選擇餐期：{{ Form::select('order_id', $orders, $order_id, ['id' => 'order_id', 'class' => 'form-control', 'placeholder' => '請先選擇餐期','onchange'=>'if(this.value != 0) { this.form.submit(); }']) }}
    {{ Form::close() }}
    <hr>
    <div class="card">
        <div class="card-header">
            <h2>教職收費單<a href="{{ route('lunch_reports.tea_money_print',$order_id) }}" class="btn btn-secondary btn-sm" target="_blank"><i class="fas fa-print"></i> 列印本月收費三聯單</a></h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-primary">
                    <th>姓名</th><th>訂餐日數</th><th>小計</th><th>收費</th>
                </tr>
                </thead>
                <tbody>
                <?php $i =0;$num=1;?>
                @foreach($user_datas as $k => $v)
                    <tr bgcolor='#FFFFFF' onmouseover="this.style.backgroundColor='#FFCDE5';" onMouseOut="this.style.backgroundColor='#FFFFFF';">
                        <td>
                            {{ $num }}-{{ $k }}
                        </td>
                        <td>
                            {{ $v }}
                        </td>
                        <td>
                            {{ $v*$tea_money }}
                        </td>
                        <td>
                            {{ round($v*$tea_money) }}
                        </td>
                    </tr>
                    <?php $i+=round($v*$tea_money); $num++;?>
                @endforeach
                <tr>
                    <td>
                        合計
                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>
                        {{ $i }}
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

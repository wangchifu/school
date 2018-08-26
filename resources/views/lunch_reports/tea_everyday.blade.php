@extends('layouts.master')

@section('page-title', '教職逐日訂餐報表')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 教職逐日訂餐報表</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">報表輸出</li>
            <li class="breadcrumb-item active" aria-current="page">教職逐日訂餐報表</li>
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

    <h2>教職逐日訂餐報表</h2>


    {{ Form::open(['route' => 'lunch_reports.tea_everyday', 'method' => 'POST']) }}
    請先選擇餐期：{{ Form::select('order_id', $orders, $this_order_id, ['id' => 'order_id', 'class' => 'form-control', 'placeholder' => '請先選擇餐期','onchange'=>'if(this.value != 0) { this.form.submit(); }']) }}
    {{ Form::close() }}
    <hr>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="100">姓名</th>
            @foreach($order_dates as $order_date)
                <th>{{ substr($order_date,5,2) }}<br>{{ substr($order_date,8,2) }}</th>
            @endforeach
            <th>
                小<br>計
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $num=1; ?>
        @foreach($user_datas as $k1=>$v1)
            <tr bgcolor='#FFFFFF' onmouseover="this.style.backgroundColor='#FFCDE5';" onMouseOut="this.style.backgroundColor='#FFFFFF';">
                <td nowrap>{{ $num }}-{{ $k1 }}<br>({{ $v1[$order_date]['place'] }})</td>
                <?php $i=0; ?>
                @foreach($order_dates as $order_date)
                    @if($v1[$order_date]['enable'] == "1")
                        <?php $i++; ?>
                        @if($v1[$order_date]['eat_style'] == "1")
                            <td><img src="{{ asset('img/meat.png') }}" alt="葷"><br>葷</td>
                        @elseif($v1[$order_date]['eat_style'] == "2")
                            <td><img src="{{ asset('img/vegetarian.png') }}" alt="素"><br>素</td>
                        @endif
                    @elseif($v1[$order_date]['enable'] == "0")
                        <td></td>
                    @endif
                @endforeach
                <td>{{ $i }}<br>次</td>
            </tr>
            <?php $num++; ?>
        @endforeach
        </tbody>
    </table>

</div>
@endsection

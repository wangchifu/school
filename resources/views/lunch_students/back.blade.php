@extends('layouts.master')

@section('page-title', '學生退餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 學生退餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item active" aria-current="page">學生訂餐</li>
        </ol>
    </nav>
    <?php
        foreach(config('app.lunch_page') as $v){
            $active[$v] = "";
        }
        $active['student'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    @if($admin)
        {{ Form::open(['route' => 'lunch_students.change_tea', 'method' => 'POST']) }}
        管理員：<input type="text" name="class_id" maxlength="3" placeholder="班級代碼"> <button class="btn btn-success btn-sm">送出</button>
        <input type="hidden" name="page" value="back">
        {{ Form::close() }}
    @endif
    <h2>{{ $class_id }}班的逐日訂餐資料</h2>
    @if($class_id)
        <h4>1.先選月份：</h4>
        {{ Form::select('select_order_id', $order_id_array,$order_id,['style'=>'font-size : 18pt','onChange'=>'location.href="back?select_order_id="+this.value']) }}
        <hr>
        <h4>2.選擇學生、日期取消訂餐：</h4>
        {{ Form::open(['route' => 'lunch_students.cancel_stu', 'method' => 'POST','id'=>'back','onsubmit'=>'return false']) }}
        學生：{{ Form::select('cancel_stu', $cancel_stus,null,['style'=>'font-size : 18pt']) }}<br><br>
        日期：{{ Form::select('cancel_date', $cancel_dates,null,['style'=>'font-size : 18pt']) }}<br><br>
        <button type="submit" class="btn btn-success btn-sm" onclick="bbconfirm_Form('back','確定幫該生退餐？')">取消該生該日訂餐</button>
        <br><br>
        {{ Form::close() }}
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th>
                   學生 / 日期
                </th>
                @foreach($order_dates as $order_date)
                <th>
                    {{ substr($order_date->order_date,5,2) }}<br>
                    {{ substr($order_date->order_date,8,2) }}
                </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($stu_data as $k1=>$v1)
            <tr>
                <td nowrap>
                    @if($v1['sex']==1)
                        {{ $k1 }} <span class="text-primary">{{ $v1['name'] }}</span>
                    @elseif($v1['sex']==2)
                        {{ $k1 }} <span class="text-danger">{{ $v1['name'] }}</span>
                    @endif

                </td>
                @foreach($order_dates as $order_date)
                    <td>
                        @if($order_data[$v1['id']][$order_date->order_date]['enable']=="eat")
                            @if($order_data[$v1['id']][$order_date->order_date]['eat_style'] ==1)
                                <span class="text-danger">葷</span>
                            @elseif($order_data[$v1['id']][$order_date->order_date]['eat_style']==2)
                                <span class="text-success">素</span>
                            @endif
                        @elseif($order_data[$v1['id']][$order_date->order_date]['enable']=="no_eat")
                                @if($order_data[$v1['id']][$order_date->order_date]['eat_style'] ==3)
                                    -
                                @endif
                        @elseif($order_data[$v1['id']][$order_date->order_date]['enable']=="abs")
                            退<a href="{{ $order_data[$v1['id']][$order_date->order_date]['id'] }}" id="reback{{ $k1 }}{{ $order_date->id }}" onclick="bbconfirm_Link('reback{{ $k1 }}{{ $order_date->id }}','確定{{ $order_date->order_date }}還原成訂餐嗎？')"><img src="{{ asset('img/remove.png') }}"></a>
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif


</div>
@endsection
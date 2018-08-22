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
    <h4>{{ $class_id }}班的逐日訂餐資料</h4>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>
               學生 / 日期
            </th>
            @foreach($order_dates as $order_date)
            <th>
                {{ substr($order_date->order_date,5,5) }}
            </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($stu_data as $k1=>$v1)
        <tr>
            <td>
                {{ $k1 }} {{ $v1['name'] }}
            </td>
            @foreach($order_dates as $order_date)
                <td>
                    {{ $order_data[$v1['id']][$order_date->order_date]['eat_style'] }}
                </td>
            @endforeach
        </tr>
        @endforeach
        </tbody>
    </table>


</div>
@endsection
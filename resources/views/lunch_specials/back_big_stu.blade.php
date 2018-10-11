@extends('layouts.master')

@section('page-title', '大量學生退訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 大量學生退訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">大量學生退訂餐</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['special'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    <div class="card">
        <div class="card-header">
            <h2>大量學生退訂餐</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => ['lunch_specials.back_big_stu_store'], 'method' => 'POST','id'=>'change_studs','onsubmit'=>'return false;']) }}
            <table class="table">
                <thead>
                <tr><th>學生(班級座號5碼,請假日期)</th></tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <textarea name="studs_data" class="form-control" rows="5" placeholder="如：10101,2017-12-01"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button class="btn btn-success" onclick="bbconfirm_Form('change_studs','你確定要更改這些學生的訂餐資料嗎？')">執行多筆</button>
                    </td>
                </tr>
                </tbody>
            </table>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

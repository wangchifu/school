@extends('layouts.master')

@section('page-title', '轉出學生退訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 轉出學生退訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">轉出學生退訂餐</li>
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
            <h2>轉出學生退訂餐</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.out_stu_store', 'method' => 'POST','id'=>'change','onsubmit'=>'return false;']) }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        班級座號5碼
                    </th>
                    <th>
                        哪一天開始不用餐
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" name="class_num" class="form-control" maxlength="5">
                    </td>
                    <td>
                        {{ Form::select('order_date', $date_data,null, ['id' => 'order_date', 'class' => 'form-control']) }}
                    </td>
                </tr>
                </tbody>
            </table>
            <button class="btn btn-success" id="b_submit" onclick="bbconfirm_Form('change','你確定你知道你在做什麼？')">更改</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

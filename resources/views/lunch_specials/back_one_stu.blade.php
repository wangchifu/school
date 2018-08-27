@extends('layouts.master')

@section('page-title', '單一學生退訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 單一學生退訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">單一學生退訂餐</li>
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
            <h2>單一學生退訂餐</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.back_one_stu_store', 'method' => 'POST','id'=>'change','onsubmit'=>'return false;']) }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        班級座號5碼
                    </th>
                    <th>
                        哪一天
                    </th>
                    <th>
                        動作
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
                    <td>
                        <input type='radio' name='enable' value='eat' id="action1"> <label for="action1"><span class="btn btn-info btn-sm">又要訂餐</span></label>　
                        <input type='radio' name='enable' value='abs' id="action2" checked> <label for="action2"><span class="btn btn-dark btn-sm">請假退餐退費</span></label>　
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

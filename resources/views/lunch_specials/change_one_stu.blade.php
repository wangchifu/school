@extends('layouts.master')

@section('page-title', '單一學生更改葷素')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 單一學生更改葷素</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">單一學生更改葷素</li>
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
            <h2>單一學生更改葷素</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.change_one_stu_store', 'method' => 'POST','id'=>'change','onsubmit'=>'return false;']) }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        班級座號5碼
                    </th>
                    <th>
                        用餐別
                    </th>
                    <th>
                        哪一天開始
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" name="class_num" class="form-control" maxlength="5">
                    </td>
                    <td>
                        <input type='radio' name='eat_style' value='1' id="eat1" checked><label for="eat1"><span class="btn btn-danger btn-sm">葷食</span></label>　
                        <input type='radio' name='eat_style' value='2' id="eat2"><label for="eat2"><span class="btn btn-success btn-sm">素食</span></label>　
                        <input type='radio' name='eat_style' value='3' id="eat3"><label for="eat3"><span class="btn btn-dark btn-sm">不訂</span></label>
                    </td>

                    <td>
                        {{ Form::select('order_date', $date_data,null, ['id' => 'order_date', 'class' => 'form-control']) }}
                    </td>
                </tr>
                </tbody>
            </table>
            <button class="btn btn-info" id="b_submit" onclick="bbconfirm_Form('change','你確定你知道你在做什麼？')">更改學生葷素</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

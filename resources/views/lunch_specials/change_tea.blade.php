@extends('layouts.master')

@section('page-title', '教職變更訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 教職變更訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">教職變更訂餐</li>
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
            <h2>變更訂餐</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.change_tea_store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
            <div class="form-group">
                <label for="user_id">訂餐的教職員</label>
                {{ Form::select('user_id', $teachers,null, ['id' => 'user_id', 'class' => 'form-control']) }}
            </div>
            <div class="form-group">
                <label for="order_date">哪一天開始改變</label>
                {{ Form::select('order_date', $date_data,null, ['id' => 'order_date', 'class' => 'form-control']) }}
            </div>
            <div class="form-group">
                <label for="user_id">用餐別</label>
                <input name="eat_style" type="radio" value="1" checked id="eat1"> <label for="eat1" class="btn btn-danger btn-sm">葷食</label>　　　
                <input name="eat_style" type="radio" value="2" id="eat2"> <label for="eat2" class="btn btn-success btn-sm">素食</label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('store','你非常確定你在做什麼嗎？')">
                    <i class="fas fa-save"></i> 儲存變更
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

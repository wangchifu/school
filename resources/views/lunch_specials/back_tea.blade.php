@extends('layouts.master')

@section('page-title', '教職退訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 教職退訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">教職退訂餐</li>
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
            <h2>教職退訂餐</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.back_tea_store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
            <div class="form-group">
                <label for="user_id">訂餐的教職員</label>
                {{ Form::select('user_id', $teachers,null, ['id' => 'user_id', 'class' => 'form-control']) }}
            </div>
            <div class="form-group">
                <label for="order_date">退哪一天的訂餐</label>
                {{ Form::select('order_date', $date_data,null, ['id' => 'order_date', 'class' => 'form-control']) }}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('store','你非常確定你在做什麼嗎？')">
                    <i class="fas fa-save"></i> 執行退餐
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

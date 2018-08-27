@extends('layouts.master')

@section('page-title', '學年單日退餐退費')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 學年單日退餐不退費</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">學年單日退餐不退費</li>
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
            <h2>學年單日退餐階退費</h2>
            <h2 class="text-danger">學年戶外教學、六年級畢業後等事先未收費！</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.back_one_year_no_money_store', 'method' => 'POST','id'=>'change','onsubmit'=>'return false;']) }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        學年代號1碼
                    </th>
                    <th>
                        哪一天
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" name="year" class="form-control" maxlength="1">
                    </td>
                    <td>
                        {{ Form::select('order_date', $date_data,null, ['id' => 'order_date', 'class' => 'form-control']) }}
                    </td>
                </tr>
                </tbody>
            </table>
            <button class="btn btn-success" id="b_submit" onclick="bbconfirm_Form('change','你確定你知道你在做什麼？')">該日退餐不退費</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

@extends('layouts.master')

@section('page-title', '全校師生單日退餐退費')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 全校師生單日退餐退費</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">全校師生單日退餐退費</li>
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
            <h2>全校師生單日退餐退費</h2>
            <h2 class="text-danger">(如颱風假)</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.back_all_school_store', 'method' => 'POST','id'=>'change','onsubmit'=>'return false;']) }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        哪一天
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        {{ Form::select('order_date', $date_data,null, ['id' => 'order_date', 'class' => 'form-control']) }}
                    </td>
                </tr>
                </tbody>
            </table>
            <button class="btn btn-success" id="b_submit" onclick="bbconfirm_Form('change','你確定你知道你在做什麼？')">該日全校師生退餐退費</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

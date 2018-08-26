@extends('layouts.master')

@section('page-title', '午餐系統')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 午餐設定</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item"><a href="{{ route('lunch_setups.index') }}">午餐設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增學期設定</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php
            $att = [
                "semester" => "",
                "tea_money" => "",
                "stud_money" => "",
                "stud_back_money" => "",
                "support_part_money" => "",
                "support_all_money" => "",
                "die_line" => "",
                "stud_gra_date" => "",
                "tea_open" => "",
                "disable" => "",
            ];
            $factory[0] = "";
            $place[0]="";
            ?>
            @include('layouts.alert')
            {{ Form::open(['route' => 'lunch_setups.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('lunch_setups.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
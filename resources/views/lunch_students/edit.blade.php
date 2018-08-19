@extends('layouts.master')

@section('page-title', '學生訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 學生訂餐</h1>
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
    <h4>{{ $class_id }}班的訂餐資料管理</h4>
    @if($admin)
        {{ Form::open(['route' => 'lunch_students.index', 'method' => 'POST']) }}
        <input type="text" name="class_id" maxlength="3" placeholder="班級代碼"> <button class="btn btn-success btn-sm">送出</button>
        {{ Form::close() }}
    @endif


</div>
@endsection
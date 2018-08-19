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
    @if($is_tea)
    <h4>{{ $class_id }}班的訂餐資料</h4>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>學期</th>
            <th>教職餐價</th>
            <th>供餐日數</th>
            <th>月份</th>
            <th>總收費</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    @else
    <h4 class="text-danger">你不是導師！</h4>
    @endif

</div>
@endsection
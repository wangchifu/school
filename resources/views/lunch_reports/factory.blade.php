@extends('layouts.master')

@section('page-title', '廠商報表')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 廠商報表</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">報表輸出</li>
            <li class="breadcrumb-item active" aria-current="page">廠商報表</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['report'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    <hr>
    <div class="card">
        <div class="card-header">
            <h2>廠商報表</h2>
        </div>
        <div class="card-body">
            <a href="{{ route('lunch_reports.for_factory') }}" class="btn btn-success btn-sm" target="_blank">按此無需登入</a>
        </div>
    </div>

</div>
@endsection

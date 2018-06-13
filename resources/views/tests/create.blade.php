@extends('layouts.master')

@section('page-title', '新增問卷')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-check-square"></i> 新增問卷</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tests.index') }}">問卷系統</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增問卷</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php
            $default_date = date('Y-m-d');
            $disable = "1";
            ?>
            @include('layouts.alert')
            {{ Form::open(['route' => 'tests.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('tests.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
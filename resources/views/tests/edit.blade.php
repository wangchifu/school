@extends('layouts.master')

@section('page-title', '修改問卷')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-check-square"></i> 修改問卷</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tests.index') }}">問卷系統</a></li>
            <li class="breadcrumb-item active" aria-current="page">修改問卷</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php
            $default_date = $test->unpublished_at;
            $disable = $test->disable;
            ?>
            @include('layouts.alert')
            {{ Form::model($test,['route' => ['tests.update',$test->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('tests.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
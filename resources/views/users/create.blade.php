@extends('layouts.master')

@section('page-title', '新增使用者')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-user"></i> 新增帳號</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">帳號列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增帳號</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('layouts.alert')
            {{ Form::open(['route' => 'users.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('users.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
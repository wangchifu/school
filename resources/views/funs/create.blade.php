@extends('layouts.master')

@section('page-title', '新增指定模組管理')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-trophy"></i> 新增指定模組管理</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('funs.index') }}">指定列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增指定</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            {{ Form::open(['route' => 'funs.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('funs.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
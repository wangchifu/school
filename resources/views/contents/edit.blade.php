@extends('layouts.master')

@section('page-title', '修改內容 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-file-alt"></i> 修改內容</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('contents.index') }}">內容列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">修改內容</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            {{ Form::model($content,['route' => ['contents.update',$content->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('contents.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
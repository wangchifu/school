@extends('layouts.master')

@section('page-title', '新增指定模組管理 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-trophy"></i> 新增指定模組管理</h1>
    <a href="{{ route('funs.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
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
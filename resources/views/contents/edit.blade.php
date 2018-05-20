@extends('layouts.master')

@section('page-title', '修改內容 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-file-alt"></i> 修改內容</h1>
    <a href="{{ route('contents.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
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
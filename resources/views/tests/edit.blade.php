@extends('layouts.master')

@section('page-title', '修改連結 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-link"></i> 修改連結</h1>
    <a href="{{ route('links.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            {{ Form::model($link,['route' => ['links.update',$link->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('links.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
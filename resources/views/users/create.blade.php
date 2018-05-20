@extends('layouts.master')

@section('page-title', '新增使用者 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1>新增使用者</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
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
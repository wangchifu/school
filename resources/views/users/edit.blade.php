@extends('layouts.master')

@section('page-title', '修改使用者 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-user"></i>修改使用者</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('layouts.alert')
            {{ Form::model($user,['route' => ['users.update',$user->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('users.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
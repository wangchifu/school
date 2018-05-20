@extends('layouts.master')

@section('page-title', '新增群組 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-users"></i> 新增群組</h1>
    <a href="{{ route('groups.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-5">
            {{ Form::open(['route' => 'groups.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('groups.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
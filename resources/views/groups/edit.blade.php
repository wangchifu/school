@extends('layouts.master')

@section('page-title', '新增群組')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-users"></i> 編輯群組</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">帳號列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">編輯群組</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-5">
            {{ Form::model($group,['route' => ['groups.update',$group->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('groups.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
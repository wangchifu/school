@extends('layouts.master')

@section('page-title', '修改會議')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-comments"></i> 修改會議</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('meetings.index') }}">會議文稿</a></li>
            <li class="breadcrumb-item active" aria-current="page">修改會議</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            <?php
            $default_date = $meeting->open_date;
            $default_name=$meeting->name;
            ?>
            {{ Form::model($meeting,['route' => ['meetings.update',$meeting->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('meetings.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
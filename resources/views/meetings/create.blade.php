@extends('layouts.master')

@section('page-title', '新增會議')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-comments"></i> 新增會議</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('meetings.index') }}">會議文稿</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增會議</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            <?php
            $default_date = date('Y-m-d');
            $default_name="教師晨會";
            ?>
            {{ Form::open(['route' => 'meetings.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('meetings.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
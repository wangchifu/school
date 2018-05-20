@extends('layouts.master')

@section('page-title', '新增會議 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1>新增會議</h1>
    <a href="{{ route('meetings.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            <?php
            $date = explode('-',date('Y-m-d'));
            $default_date = $date[1]."/".$date[2]."/".$date[0];
            $default_name="教師晨會";
            ?>
            {{ Form::open(['route' => 'meetings.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('meetings.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
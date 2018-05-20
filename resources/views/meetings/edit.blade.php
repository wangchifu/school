@extends('layouts.master')

@section('page-title', '修改會議 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1>修改會議</h1>
    <a href="{{ route('meetings.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            <?php
            $date = explode('-',$meeting->open_date);
            $default_date = $date[1]."/".$date[2]."/".$date[0];
            $default_name=$meeting->name;
            ?>
            {{ Form::model($meeting,['route' => ['meetings.update',$meeting->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('meetings.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
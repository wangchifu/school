@extends('layouts.master')

@section('page-title', '修改問卷 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-check-square"></i> 修改問卷</h1>
    <a href="{{ route('tests.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php
            $default_date = $test->unpublished_at;
            $disable = $test->disable;
            ?>
            @include('layouts.alert')
            {{ Form::model($test,['route' => ['tests.update',$test->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('tests.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')

@section('page-title', '新增問卷題目 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-check-square"></i> 新增問卷題目</h1>
    <a href="{{ route('tests.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php
            $default_date = date('Y-m-d');
            $disable = "1";
            ?>
            @include('layouts.alert')
            {{ Form::open(['route' => 'tests.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('tests.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
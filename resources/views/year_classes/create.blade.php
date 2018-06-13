@extends('layouts.master')

@section('page-title', '新增學期')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-calendar-alt"></i> 新增學期</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">學生系統</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增學期</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
            <div class="col-md-5">
                @include('layouts.alert')
                {{ Form::open(['route' => 'year_classes.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
                <div class="card my-4">
                    <h3 class="card-header">學期資料</h3>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="semester">學年學期(1061)*</label>
                            {{ Form::text('semester',null,['id'=>'semester','class' => 'form-control','maxlength'=>'4']) }}
                        </div>
                        <div class="form-group">
                            <label for="class1">一年級班級數*</label>
                            {{ Form::text('class1',null,['id'=>'class1','class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label for="class2">二年級班級數*</label>
                            {{ Form::text('class2',null,['id'=>'class2','class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label for="class3">三年級班級數*</label>
                            {{ Form::text('class3',null,['id'=>'class3','class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label for="class4">四年級班級數*</label>
                            {{ Form::text('class4',null,['id'=>'class4','class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label for="class5">五年級班級數*</label>
                            {{ Form::text('class5',null,['id'=>'class5','class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label for="class6">六年級班級數*</label>
                            {{ Form::text('class6',null,['id'=>'class6','class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label for="class9">特教班級數*</label>
                            {{ Form::text('class9',null,['id'=>'class9','class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                                <i class="fas fa-save"></i> 儲存設定
                            </button>
                        </div>

                    </div>
                </div>
                {{ Form::close() }}
            </div>
    </div>
</div>

@endsection
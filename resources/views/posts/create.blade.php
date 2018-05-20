@extends('layouts.master')

@section('page-title', '新增公告 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-bullhorn"></i> 新增公告</h1>
    {{ Form::open(['route' => 'posts.store', 'method' => 'POST','id'=>'setup', 'files' => true,'onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">公告資料</h3>
        <div class="card-body">
            @include('layouts.alert')
            <div class="form-group">
                <label for="job_title"><strong>1.職稱*</strong></label>
                {{ Form::text('job_title',auth()->user()->job_title,['id'=>'job_title','class' => 'form-control', 'readonly' => 'readonly']) }}
            </div>
            <div class="form-group">
                <label for="content">2.校內文件?</label>
                <div class="form-check">
                    {{ Form::checkbox('insite', '1',null,['id'=>'insite','class'=>'form-check-input']) }}
                    <label class="form-check-label" for="insite"><span class="btn btn-info btn-sm">設定</span></label>
                </div>
            </div>
            <div class="form-group">
                <label for="content">3.標題圖片</label>
                {{ Form::file('title_image', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                <label for="title"><strong>4.標題*</strong></label>
                {{ Form::text('title',null,['id'=>'title','class' => 'form-control', 'placeholder' => '請輸入標題']) }}
            </div>
            <div class="form-group">
                <label for="content"><strong>5.內文*</strong></label>
                {{ Form::textarea('content', null, ['id' => 'content', 'class' => 'form-control', 'rows' => 10, 'placeholder' => '請輸入內容']) }}
            </div>
            <div class="form-group">
                <label for="files[]">6.附件( 不大於5MB )</label>
                {{ Form::file('files[]', ['class' => 'form-control','multiple'=>'multiple']) }}
            </div>
            <div class="form-group">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary"><i class="fas fa-backward"></i> 返回</a>
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
@endsection
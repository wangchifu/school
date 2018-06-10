@extends('layouts.master')

@section('page-title', '新增報告 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-comment"></i> 新增報告</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('meetings.index') }}">會議列表</a></li>
            <li class="breadcrumb-item"><a href="{{ route('meetings.show',$meeting->id) }}">{{ $meeting->open_date }} {{ $meeting->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增報告</li>
        </ol>
    </nav>
    {{ Form::open(['route' => 'meetings_reports.store', 'method' => 'POST','id'=>'setup', 'files' => true,'onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">{{ $meeting->open_date }} {{ $meeting->name }} 報告資料</h3>
        <div class="card-body">
            @include('layouts.alert')
            <div class="form-group">
                <label for="job_title"><strong>職稱*</strong></label>
                {{ Form::text('job_title',auth()->user()->job_title,['id'=>'job_title','class' => 'form-control', 'readonly' => 'readonly']) }}
            </div>
            <div class="form-group">
                <label for="content"><strong>內容*</strong></label>
                {{ Form::textarea('content', null, ['id' => 'content', 'class' => 'form-control', 'rows' => 10, 'placeholder' => '請輸入內容']) }}
            </div>
            <div class="form-group">
                <label for="files[]">( 不大於5MB，若為文字檔，請改為[ <a href="https://www.ndc.gov.tw/cp.aspx?n=d6d0a9e658098ca2" target="_blank">ODF格式</a> ] [ 詳細公文 ] [ 轉檔教學 ] )</label>
                {{ Form::file('files[]', ['class' => 'form-control','multiple'=>'multiple']) }}
            </div>
            <div class="form-group">
                <a href="{{ route('meetings.show',$meeting->id) }}" class="btn btn-secondary"><i class="fas fa-backward"></i> 返回</a>
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
            </div>
        </div>
    </div>
    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
    {{ Form::close() }}
</div>
@endsection
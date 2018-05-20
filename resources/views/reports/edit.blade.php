@extends('layouts.master')

@section('page-title', '修改報告 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1>修改報告</h1>
    {{ Form::model($report,['route' => ['meetings_reports.update',$report->id], 'method' => 'PATCH','id'=>'setup', 'files' => true,'onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">{{ $report->meeting->open_date }} {{ $report->meeting->name }} 報告資料</h3>
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
                <label for="files[]">附件( 不大於5MB )</label>
                @if(!empty($files))
                    @foreach($files as $k=>$v)
                        <?php
                        $file = "reports/".$report->id."/".$v;
                        $file = str_replace('/','&',$file);
                        ?>
                        <a href="{{ url('meetings_reports/'.$file.'/fileDel') }}" class="btn btn-danger btn-sm" id="fileDel{{ $k }}" onclick="bbconfirm_Link('fileDel{{ $k }}','確定刪附件？')"><i class="fas fa-times-circle"></i> {{ $v }}</a>
                    @endforeach
                @endif
                {{ Form::file('files[]', ['class' => 'form-control','multiple'=>'multiple']) }}
            </div>
            <div class="form-group">
                <a href="{{ route('meetings.show',$report->meeting_id) }}" class="btn btn-secondary"><i class="fas fa-backward"></i> 返回</a>
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
@endsection
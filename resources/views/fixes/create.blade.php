@extends('layouts.master')

@section('page-title', '新增報修項目')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-wrench"></i> 新增報修項目</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fixes.index') }}">報修列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增報修</li>
        </ol>
    </nav>
    {{ Form::open(['route' => 'fixes.store', 'method' => 'POST','id'=>'setup', 'files' => true,'onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">報修資料</h3>
        <div class="card-body">
            @include('layouts.alert')
            <div class="form-group">
                <label for="type">類別*</label>
                <?php $types=['1'=>'資訊設備(不含印表機)']; ?>
                {{ Form::select('type', $types,null, ['id' => 'type', 'class' => 'form-control']) }}
            </div>
            <div class="form-group">
                <label for="title"><strong>標題*</strong></label>
                {{ Form::text('title',null,['id'=>'title','class' => 'form-control', 'placeholder' => '請輸入標題']) }}
            </div>
            <div class="form-group">
                <label for="content"><strong>內文*</strong></label>
                {{ Form::textarea('content', '設備地點：'."\r\n".'待修狀況：', ['id' => 'content', 'class' => 'form-control','rows' => 10, 'placeholder' => '請寫清楚發生位置和情況']) }}
            </div>
            <div class="form-group">
                <a href="{{ route('fixes.index') }}" class="btn btn-secondary"><i class="fas fa-backward"></i> 返回</a>
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
@endsection
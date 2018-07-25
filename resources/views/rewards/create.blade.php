@extends('layouts.master')

@section('page-title', '新增獎狀填報')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-check-square"></i> 新增獎狀填報</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">獎狀填報列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增獎狀填報</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            {{ Form::open(['route' => 'rewards.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
            <div class="card my-4">
                <h3 class="card-header">獎狀填報資料</h3>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">
                            <strong class="text-danger">名稱*</strong>
                            <small class="text-primary">(如：1061學期第一階段評量)</small>
                        </label>
                        {{ Form::text('name',null,['id'=>'name','class' => 'form-control', 'placeholder' => '請填名稱']) }}
                    </div>
                    <div class="form-group">
                        <label for="description">說明</label>
                        {{ Form::text('description',null,['id'=>'description','class'=>'form-control']) }}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('store','確定儲存嗎？')">
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
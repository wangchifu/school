@extends('layouts.master')

@section('page-title', '校務行事曆-週次設定')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-calendar"></i> 校務行事曆-週次設定</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('calendars.index') }}">校務行事曆</a></li>
            <li class="breadcrumb-item active" aria-current="page">週次設定</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4>{{ $semester }}學期 週次設定，請新增或移除多餘週次</h4>
        </div>
        <div class="card-body">
        {{ Form::open(['route' => 'calendars.week_store','id'=>'save' ,'method' => 'POST','onsubmit'=>'return false;']) }}
        <table class="table table-hover">
            <thead>
            <tr>
                <th>
                    週次
                </th>
                <th>
                    起迄
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    {{ Form::text('week[d]',null,['class' => 'form-control']) }}
                </td>
                <td>
                    {{ Form::text('start_end[d]',null,['class' => 'form-control']) }}
                </td>
            </tr>
        @foreach($start_end as $k=>$v)
            <tr>
                <td>
                    {{ Form::text('week['.$k.']',$k,['class' => 'form-control']) }}
                </td>
                <td>
                    {{ Form::text('start_end['.$k.']',substr($v[0],5,5).'~'.substr($v[6],5,5),['class' => 'form-control']) }}
                </td>
            </tr>
        @endforeach
            </tbody>
        </table>
            <input type="hidden" name="semester" value="{{ $semester }}">
            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('save','確定儲存嗎？')">
                <i class="fas fa-save"></i> 儲存設定
            </button>
        {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
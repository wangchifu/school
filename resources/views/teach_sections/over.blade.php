@extends('layouts.master')

@section('page-title', '教學組')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-user-times"></i> 教學組</h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#">代課.兼課.超鐘點費</a>
        </li>
    </ul>
    <hr>
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('teach_section.index') }}" class="btn btn-light">操作說明</a>
        <a href="{{ route('substitute_teacher.index') }}" class="btn btn-success">代課名單</a>
        <a href="{{ route('month_setup.index') }}" class="btn btn-info">月份設定</a>
        <a href="{{ route('c_group.index') }}" class="btn btn-secondary">輔導團案</a>
        <a href="{{ route('support.index') }}" class="btn btn-secondary">支援教師</a>
        <a href="{{ route('taxation.index') }}" class="btn btn-secondary">兼課教師</a>
        <a href="" class="btn btn-secondary">短期代理</a>
        <a href="{{ route('over.index') }}" class="btn btn-secondary active">超鐘點案</a>
        <a href="#" class="btn btn-danger">請假排代</a>
    </div>
    <hr>
    <div class="card">
        <div class="card-header">
            <h3>超鐘點案</h3>
        </div>
        <div class="card-body">
            
        </div>
    </div>
</div>
@endsection
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
        <a href="{{ route('teach_section.index') }}" class="btn btn-light active">操作說明</a>
        <a href="{{ route('substitute_teacher.index') }}" class="btn btn-success">代課名單</a>
        <a href="{{ route('month_setup.index') }}" class="btn btn-info">月份設定</a>
        <a href="{{ route('c_group.index') }}" class="btn btn-secondary">輔導團案</a>
        <a href="{{ route('support.index') }}" class="btn btn-secondary">支援教師</a>
        <a href="{{ route('taxation.index') }}" class="btn btn-secondary">兼課教師</a>
        <a href="{{ route('short.index') }}" class="btn btn-secondary">短期代理</a>
        <a href="{{ route('over.index') }}" class="btn btn-secondary">超鐘點案</a>
        <a href="{{ route('teacher_abs.index') }}" class="btn btn-danger">請假排代</a>
        <a href="{{ route('class_teacher.index') }}" class="btn btn-dark">導師請假</a>
    </div>
    <hr>
    <div class="card">
        <div class="card-header">
            <h3>操作說明</h3>
        </div>
        <div class="card-body">
            <ol>
                <li>先設定好代課名單。</li>
                <li>在「月份設定」標示各月份國訂假日、寒暑假、颱風假等不上課日期。</li>
                <li>代理輔導團課務、支援教師、課稅方案兼課教師、超鐘點教師，以上期初優先排定。</li>
                <li>請假排代，於學期中排代。</li>
            </ol>
        </div>
    </div>
</div>
@endsection
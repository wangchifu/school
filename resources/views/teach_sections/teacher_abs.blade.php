@extends('layouts.master')

@section('page-title', '教學組')

@section('content')
<script src="{{ asset('gijgo/js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css">
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
        <a href="{{ route('short.index') }}" class="btn btn-secondary">短期代理</a>
        <a href="{{ route('over.index') }}" class="btn btn-secondary">超鐘點案</a>
        <a href="{{ route('teacher_abs.index') }}" class="btn btn-danger active">請假排代</a>
        <a href="{{ route('class_teacher.index') }}" class="btn btn-dark">導師請假</a>
    </div>
    <hr>
    <a href="{{ route('teacher_abs.report') }}" class="btn btn-primary" target="_blank"><i class="fas fa-file"></i> 「請假排代」報表產生器</a>
    <div class="card">
        <div class="card-header">
            <h3>請假排代</h3>
        </div>
        <div class="card-body">
            <h2>已建列表</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th nowrap width="120">
                        代課教師
                    </th>
                    <th nowrap width="150">
                        代課日期
                    </th>
                    <th nowrap width="120">
                        請假者
                    </th>
                    <th nowrap>
                        請假事由
                    </th>
                    <th nowrap width="100">
                        節數
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($ori_subs as $ori_sub)
                    <?php
                        $ori_teacher = \App\User::where('id',$ori_sub->ori_teacher)->first();
                        $sub_teacher = \App\SubstituteTeacher::where('id',$ori_sub->sub_teacher)->first();
                    ?>
                    <tr>
                        <td>
                            {{ $sub_teacher->teacher_name }}
                        </td>
                        <td>
                            {{ $ori_sub->abs_date }}
                        </td>
                        <td>
                            {{ $ori_teacher->name }}
                        </td>
                        <td>
                            {{ $ori_sub->ps }}
                        </td>
                        <td>
                            {{ $ori_sub->section }} <a href="{{ route('teacher_abs.show',$ori_sub->id) }}" class="btn btn-info btn-sm" target="_blank">詳細</a>
                        </td>
                        <td>
                            <a href="{{ route('teacher_abs.delete',$ori_sub->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('確定刪除？')">刪除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <hr>
            <h2>新增</h2>
            {{ Form::open(['route'=>'teacher_abs.store','method'=>'POST']) }}
            <table class="table table-striped">
                <thead>
                <tr>
                    <th nowrap width="120">
                        代課教師
                    </th>
                    <th nowrap width="150">
                        代課日期
                    </th>
                    <th nowrap width="120">
                        請假者
                    </th>
                    <th nowrap>
                        請假事由
                    </th>
                    <th nowrap width="100">
                        節數
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td>
                        {{ Form::select('sub_teacher',$substitute_teachers,null,['class'=>'form-control']) }}
                    </td>
                    <td>
                        <input id="datepicker" width="150" name="abs_date" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>
                    </td>
                    <td>
                        {{ Form::select('ori_teacher',$select_users,null,['class'=>'form-control']) }}
                    </td>
                    <td>
                        {{ Form::text('ps',null,['class' => 'form-control', 'required' => 'required']) }}
                    </td>
                    <td>
                        <table class="table table-striped">
                            <tr>
                                <td>

                                </td>
                                <td>
                                    節次
                                </td>
                            </tr>
                            @for($i=1;$i<8;$i++)
                                <tr>
                                    <td>
                                        {{ $i }}
                                    </td>
                                    <td>
                                        <input type="checkbox" name="sub[{{ $i }}]">
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('確定新增？')"><i class="fas fa-plus-circle"></i> 新增</button>
                    </td>
                </tr>
                <input type="hidden" name="type" value="teacher_abs">
                <input type="hidden" name="semester" value="{{ $semester }}">

                </tbody>
            </table>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
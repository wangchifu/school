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
        <a href="{{ route('taxation.index') }}" class="btn btn-secondary active">兼課教師</a>
        <a href="{{ route('short.index') }}" class="btn btn-secondary">短期代理</a>
        <a href="{{ route('over.index') }}" class="btn btn-secondary">超鐘點案</a>
        <a href="{{ route('teacher_abs.index') }}" class="btn btn-danger">請假排代</a>
        <a href="{{ route('class_teacher.index') }}" class="btn btn-dark">導師請假</a>
    </div>
    <hr>
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
                </tbody>
            </table>
            <hr>
            <h2>新增</h2>
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
                {{ Form::open(['route'=>'teacher_abs.store','method'=>'POST']) }}
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
                                    一
                                </td>
                                <td>
                                    二
                                </td>
                                <td>
                                    三
                                </td>
                                <td>
                                    四
                                </td>
                                <td>
                                    五
                                </td>
                            </tr>
                            @for($i=1;$i<8;$i++)
                                <tr>
                                    <td>
                                        {{ $i }}
                                    </td>
                                    <td>
                                        <input type="checkbox" name="sub1[{{ $i }}]">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="sub2[{{ $i }}]">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="sub3[{{ $i }}]">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="sub4[{{ $i }}]">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="sub5[{{ $i }}]">
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
                {{ Form::close() }}
                </tbody>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
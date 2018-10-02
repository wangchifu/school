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
        <a href="{{ route('c_group.index') }}" class="btn btn-secondary active">輔導團案</a>
        <a href="{{ route('support.index') }}" class="btn btn-secondary">支援教師</a>
        <a href="{{ route('taxation.index') }}" class="btn btn-secondary">兼課教師</a>
        <a href="" class="btn btn-secondary">短期代理</a>
        <a href="{{ route('over.index') }}" class="btn btn-secondary">超鐘點案</a>
        <a href="#" class="btn btn-danger">請假排代</a>
    </div>
    <hr>
    <a href="{{ route('c_group.report') }}" class="btn btn-primary" target="_blank"><i class="fas fa-file"></i> 輔導團報表產生器</a>
    <div class="card">
        <div class="card-header">
            <h3>{{ $semester }}輔導團案</h3>
        </div>
        <div class="card-body">
            <h2>已建列表</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        代課老師
                    </th>
                    <th>
                        接任輔導團教師
                    </th>
                    <th>
                        備註
                    </th>
                    <th>
                        每週節數
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                @foreach($ori_subs as $ori_sub)
                    <?php

                    $ori_teacher = \APP\User::where('id',$ori_sub->ori_teacher)->first();
                    $sub_teacher = \APP\User::where('id',$ori_sub->sub_teacher)->first();
                    ?>
                    <tr>
                        <td>
                            {{ $sub_teacher->name }}
                        </td>
                        <td>
                            {{ $ori_teacher->name }}
                        </td>
                        <td>
                            {{ $ori_sub->ps }}
                        </td>
                        <td>
                            {{ $ori_sub->section }} <a href="{{ route('c_group.show',$ori_sub->id) }}" class="btn btn-info btn-sm"  target="_blank">詳細</a>
                        </td>
                        <td>
                            <a href="{{ route('c_group.delete',$ori_sub->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('當真要刪？')">刪除</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
            <hr>
            <h2>新增</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        代課老師
                    </th>
                    <th>
                        接任輔導團教師
                    </th>
                    <th>
                        備註
                    </th>
                    <th>
                        課表
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                {{ Form::open(['route'=>'c_group.store','method'=>'POST']) }}
                <tbody>
                <tr>
                    <td>
                        {{ Form::select('sub_teacher',$select_users,null,['class'=>'form-control']) }}
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
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('確定新增？記得填寫節次')">確定新增</button>
                    </td>
                </tr>
                <input type="hidden" name="type" value="c_group">
                <input type="hidden" name="semester" value="{{ $semester }}">
                {{ Form:: close() }}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')

@section('page-title', '代課名單')

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
        <a href="{{ route('substitute_teacher.index') }}" class="btn btn-success active">代課名單</a>
        <a href="{{ route('month_setup.index') }}" class="btn btn-info">月份設定</a>
        <a href="#" class="btn btn-secondary">輔導團案</a>
        <a href="#" class="btn btn-secondary">支援教師</a>
        <a href="#" class="btn btn-secondary">課稅方案</a>
        <a href="#" class="btn btn-secondary">超鐘點案</a>
        <a href="#" class="btn btn-danger">請假排代</a>
        <a href="#" class="btn btn-primary">報表輸出</a>
    </div>
    <hr>
    <div class="card">
        <div class="card-header">
            <h3>代課名單</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-5">
                    {{ Form::open(['route' => 'substitute_teacher.store', 'method' => 'POST']) }}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td>
                                姓名
                            </td>
                            <td>
                                備註
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                {{ Form::text('teacher_name',null,['class' => 'form-control', 'required'=>'required']) }}
                            </td>
                            <td>
                                {{ Form::text('ps',null,['class' => 'form-control']) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('確定新增？')"><i class="fas fa-plus-circle"></i> 新增</button>
                    {{ Form::close() }}
                </div>
                <div class="col-7">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td width="120">
                                姓名
                            </td>
                            <td width="150">
                                備註
                            </td>
                            <td>
                                狀況
                            </td>
                            <td>
                                動作
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($substitute_teachers as $substitute_teacher)
                            {{ Form::open(['route' => ['substitute_teacher.update',$substitute_teacher->id], 'method' => 'PATCH']) }}
                            <tr>
                                <?php
                                    $style = ($substitute_teacher->active=="1")?"text-dark":"text-danger";
                                ?>
                                <td>
                                    {{ Form::text('teacher_name',$substitute_teacher->teacher_name,['class' => 'form-control '.$style, 'required'=>'required']) }}
                                </td>
                                <td>
                                    {{ Form::text('ps',$substitute_teacher->ps,['class' => 'form-control']) }}
                                </td>
                                <td>
                                    @if($substitute_teacher->active=="1")
                                        <a href="{{ route('substitute_teacher.change',$substitute_teacher->id) }}" class="btn btn-outline-success btn-sm" onclick="return confirm('想要停用？')">啟用</a>
                                    @elseif($substitute_teacher->active=="2")
                                        <a href="{{ route('substitute_teacher.change',$substitute_teacher->id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('想要啟用？')">停用</a>
                                    @endif
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('確定儲存？')">儲存</button>
                                    <a href="{{ route('substitute_teacher.destroy',$substitute_teacher->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('建議不要刪除！否則已有代課資料會對應不到，除非真的肯定是多餘的！！')">刪除</a>
                                </td>
                            </tr>
                            {{ Form::close() }}
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
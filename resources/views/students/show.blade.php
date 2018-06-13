@extends('layouts.master')

@section('page-title', '班級學生')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-child"></i> 班級學生</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">學生系統</a></li>
            <li class="breadcrumb-item active" aria-current="page">班級學生</li>
        </ol>
    </nav>
    <div class="card my-4">
        <div class="card-header">班級管理：{{ $year_class->semester }} 學期 {{ $year_class->name }}</div>
        <div class="card-body">
            @if($student_admin)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="100">
                        班級代號
                    </th>
                    <th width="100">
                        座號
                    </th>
                    <th width="120">
                        學號
                    </th>
                    <th width="200">
                        姓名
                    </th>
                    <th width="100">
                        性別
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    {{ Form::open(['route' => ['students.add_stud',$year_class->id], 'method' => 'POST','id' => 'add_stud','onsubmit'=>'return false;']) }}
                    <input type="hidden" name="semester" value="{{$year_class->semester}}">
                    <td>
                        {{ Form::text('year_class',$year_class->year_class, ['id' => 'year_class', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                        <input type="hidden" name="year_class_id" value="{{ $year_class->id }}">
                    </td>
                    <td>
                        {{ Form::text('num',null, ['id' => 'num', 'class' => 'form-control','maxlength'=>'2', 'placeholder' => '2碼']) }}
                    </td>
                    <td>
                        {{ Form::text('sn',null, ['id' => 'sn', 'class' => 'form-control','maxlength'=>'6', 'placeholder' => '6碼']) }}
                    </td>
                    <td>
                        {{ Form::text('name',null, ['id' => 'name', 'class' => 'form-control', 'placeholder' => '學生姓名']) }}
                    </td>
                    <td>
                        <?php $stud_sex = [1=>'男',2=>'女']; ?>
                        {{ Form::select('sex', $stud_sex, 1, ['id' => 'sex', 'class' => 'form-control','required'=>'required']) }}
                    </td>
                    <td>
                        <button class="btn btn-success btn-xs" onclick="bbconfirm_Form('add_stud','確定要新增嗎？')"><i class="fas fa-plus"></i> 新增學生</button>
                    </td>
                    {{ Form::close() }}
                </tr>
                </tbody>
            </table>
            <hr>
            @endif
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="100">
                        班級代號
                    </th>
                    <th width="100">
                        座號
                    </th>
                    <th width="120">
                        學號
                    </th>
                    <th width="200">
                        姓名
                    </th>
                    <th width="100">
                        性別
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($student_data as $k=>$v)
                    @if($student_admin)
                    {{ Form::open(['route' => 'students.update', 'method' => 'PATCH','id' => 'year_class'.$k,'onsubmit'=>'return false;']) }}
                    <input type="hidden" name="semester" value="{{ $year_class->semester }}">
                    <input type="hidden" name="id" value="{{ $v['id'] }}">
                    <tr>
                        <td>
                            {{ Form::select('year_class', $classes, $v['班級'], ['id' => 'year_class', 'class' => 'form-control','required'=>'required']) }}
                        </td>
                        <td>
                            {{ Form::text('num',$k, ['id' => 'num', 'class' => 'form-control','maxlength'=>'2', 'placeholder' => '請輸入座號']) }}
                        </td>
                        <td>
                            {{ Form::text('sn',$v['學號'], ['id' => 'sn', 'class' => 'form-control', 'readonly' => 'readonly']) }}
                        </td>
                        <td>
                            {{ Form::text('name',$v['姓名'], ['id' => 'name', 'class' => 'form-control', 'placeholder' => '請輸入學生姓名']) }}
                        </td>
                        <td>
                            {{ Form::select('sex', $stud_sex, $v['性別'], ['id' => 'sex', 'class' => 'form-control','required'=>'required']) }}
                        </td>
                        <td>
                            <button class="btn btn-info btn-xs" onclick="bbconfirm_Form('year_class{{ $k }}','你真的要修改嗎？')"><i class="fas fa-save"></i> 儲存</button> <a href="{{ route('students.out',$v['id']) }}" class="btn btn-danger btn-xs" id="out{{ $v['學號'] }}" onclick="bbconfirm_Link('out{{ $v['學號'] }}','確定要轉出？')"><i class="fas fa-undo-alt"></i> 轉出</a>
                        </td>
                    </tr>
                    {{ Form::close() }}
                    @else
                        <tr>
                            <td>
                                {{ $v['班級'] }}
                            </td>
                            <td>
                                {{ $k }}
                            </td>
                            <td>
                                {{ $v['學號'] }}
                            </td>
                            <td>
                                {{ $v['姓名'] }}
                            </td>
                            <td>
                                @if($v['性別'] == "1")
                                    男
                                @else
                                    女
                                @endif
                            </td>
                            <td>

                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
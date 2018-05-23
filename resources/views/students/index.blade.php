@extends('layouts.master')

@section('page-title', '學生系統 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-child"></i> 學生系統</h1>
    @if($student_admin)
        <a href="{{ route('year_classes.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增學期</a>
    @endif
    <br><br>
    <div class="card my-4">
        <div class="card-header">查詢學期</div>
        <div class="card-body">
        {{ Form::open(['route' => 'students.index', 'method' => 'POST']) }}
        {{ Form::select('semester', $semesters, $semester, ['id' => 'semester', 'class' => 'form-control','placeholder'=>'請選擇學期','onchange'=>'if(this.value != 0) { this.form.submit(); }']) }}
        {{ Form::close() }}
        </div>
    </div>
    @if(!empty($semester))
        <table class="table">
            <tr>
                <td>
                    <div class="card my-4">
                        <div class="card-header">{{ $semester }} 學期班級學生統計
                            @if($student_admin)
                                <a href="{{ route('students.clear_all',$semester) }}" class="btn btn-danger btn-sm" id="clear_all" onclick="bbconfirm_Link('clear_all','確定全刪了嗎？')"><i class="fas fa-trash"></i> 清除本學期班級及學生資料</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>
                                        年級
                                    </th>
                                    <th>
                                        班級數
                                    </th>
                                    <th>
                                        人數
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($year_class)
                                    @foreach($year_class as $k=>$v)
                                        <tr>
                                            <td>
                                                {{ $k }}
                                            </td>
                                            <td>
                                                {{ $v }} 班
                                            </td>
                                            <td>
                                                {{ $year_stud[$k] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="card my-4">
                        <div class="card-header">{{ $semester }} 學期轉出學生統計
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>
                                        學號
                                    </th>
                                    <th>
                                        班級
                                    </th>
                                    <th>
                                        姓名
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($out_students as $k=>$v)
                                    <tr>
                                        <td>
                                            {{ $k }}
                                        </td>
                                        <td>
                                            {{ $v['班級'] }}
                                        </td>
                                        <td>
                                            {{ $v['姓名'] }}
                                        </td>
                                        <td>
                                            @if($student_admin)
                                            <a href="{{ route('students.rein',$v['id']) }}" class="btn btn-info btn-sm"><i class="fas fa-redo-alt"></i> 本學期又轉入</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    @if($all_student != 0)
    <div class="card my-4">
        <div class="card-header">{{ $semester }} 學期各班詳細資料
            @if($student_admin)
            <a href="{{ route('students.clear_students',$semester) }}" class="btn btn-danger btn-sm" id="clear_students" onclick="bbconfirm_Link('clear_students','確定嗎？')"><i class="fas fa-trash"></i> 清除本學期學生資料</a>
            @endif
        </div>
        <div class="card-body">
            @if($student_admin)
            {{ Form::open(['route'=>'year_classes.update','method'=>'patch','id'=>'store_class_tea','onsubmit'=>'return false']) }}
            <a href="#" class="btn btn-primary" onclick="bbconfirm_Form('store_class_tea','確定嗎？')"><i class="fas fa-save"></i> 確定級任老師</a>
            @endif
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        班級代號
                    </th>
                    <th>
                        班級名稱
                    </th>
                    <th>
                        班級人數 ( 男；女 )
                    </th>
                    <th>
                        級任老師
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($YearClasses as $YearClass)
                    <tr>
                        <td>
                            {{ $YearClass->year_class }}
                        </td>
                        <td>
                            <a href="{{ route('students.show',$YearClass->id) }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-circle-right"></i> {{ $YearClass->name }}</a>
                        </td>
                        <td>
                            {{ $students_data[$YearClass->id]['num'] }} 人 ( 男： {{ $students_data[$YearClass->id]['boy'] }} 人 ； 女： {{ $students_data[$YearClass->id]['girl'] }} 人)
                        </td>
                        <td>
                            @if(empty($YearClass->user_id) and $student_admin == "1")
                            {{ Form::select('class_tea['.$YearClass->id.']', $tea_menu, null, ['class' => 'form-control', 'placeholder' => '請選擇級任']) }}
                            @else
                                @if(!empty($YearClass->user_id))
                                    {{ $YearClass->user->name }}
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($student_admin)
            <a href="#" class="btn btn-primary" onclick="bbconfirm_Form('store_class_tea','確定嗎？')"><i class="fas fa-save"></i> 確定級任老師</a>
            {{ Form::close() }}
            @endif
        </div>
    </div>
    @else
        @if($student_admin)
            {{ Form::open(['route' => 'students.import','id'=>'upload','method' => 'POST','files'=>true,'onsubmit'=>'return false;']) }}
            匯入學生：
            <table>
                <tr>
                    <td>
                        <input name="csv" type="file" required="required" class="form-control">
                    </td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm" onclick="bbconfirm_Form('upload','確定匯入？')"><i class="fas fa-upload"></i> 匯入學生資料CSV檔</a>
                    </td>
                    <td>
                        <a href="{{ url('public_file/&csv&students_demo.csv')}}" class="btn btn-primary btn-sm"><i class="fas fa-download"></i> 下載CSV範例檔</a>
                    </td>
                </tr>
            </table>
            {{ Form::close() }}
        @endif
    @endif

    @endif
</div>
@endsection
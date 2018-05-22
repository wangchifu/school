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
    <div class="card my-4">
        <div class="card-header">{{ $semester }} 學期班級學生統計
            @if($student_admin)
            <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> 清除本學期班級及學生資料</a>
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

                            </td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td>
                        全校人數
                    </td>
                    <td>
                        {{ $all_student }} 人
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
        @if($all_student != 0)
        <div class="card my-4">
            <div class="card-header">{{ $semester }} 學期各班詳細資料
                @if($student_admin)
                <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> 清除學生資料</a>
                @endif
            </div>
            <div class="card-body">
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

                    </tbody>
                </table>
            </div>
        </div>
        @else
            <a href="#" class="btn btn-success btn-sm"><i class="fas fa-gofore"></i> 匯入學生資料</a>
        @endif

    @endif
</div>
@endsection
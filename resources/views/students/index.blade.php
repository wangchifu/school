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
        {{ Form::select('semester', $semesters, $semester, ['id' => 'semester', 'class' => 'form-control', 'placeholder' => '請選擇學期','onchange'=>'if(this.value != 0) { this.form.submit(); }']) }}
        {{ Form::close() }}
        </div>
    </div>

</div>
@endsection
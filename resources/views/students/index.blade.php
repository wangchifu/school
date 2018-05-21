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

</div>
@endsection
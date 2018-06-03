@extends('layouts.master')

@section('page-title', '教室預約 | 和東國小')

@section('content')
    <br><br><br>
    <div class="container">
        <h1><i class="fas fa-warehouse"></i> 教室預約</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
                <li class="breadcrumb-item active" aria-current="page">教室預約</li>
            </ol>
        </nav>
        @if(auth()->user()->admin)
            <a href="{{ route('classrooms.index') }}" class="btn btn-warning btn-sm"><i class="fas fa-cog"></i> 教室管理</a>
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <th nowrap>序號</th>
                <th nowrap>名稱</th>
                <th nowrap>狀態</th>
                <th nowrap>不開放節次</th>
                <th>動作</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection
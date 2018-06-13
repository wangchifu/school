@extends('layouts.master')

@section('page-title', '教室預約')

@section('content')
    <br><br><br>
    <div class="container">
        <h1><i class="fas fa-warehouse"></i> 教室預約列表</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
                <li class="breadcrumb-item active" aria-current="page">教室預約列表</li>
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
                <th>動作</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; ?>
            @foreach($classrooms as $classroom)
                <td>{{ $i }}</td>
                <td>{{ $classroom->name }}</td>
                <td>
                    <a href="{{ route('classroom_orders.show',['classroom'=>$classroom->id,'select_sunday'=>date('Y-m-d')]) }}" class="btn btn-info btn-sm"><i class="fas fa-check-circle"></i> 預約</a>
                </td>
                <?php $i++; ?>
            @endforeach


            </tbody>
        </table>
    </div>
@endsection
@extends('layouts.master')

@section('page-title', '教室管理 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-warehouse"></i> 教室管理</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('classroom_orders.index') }}">教室預約</a></li>
            <li class="breadcrumb-item active" aria-current="page">教室管理</li>
        </ol>
    </nav>
    <a href="{{ route('classrooms.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增教室</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th nowrap>序號</th>
            <th nowrap>名稱</th>
            <th nowrap>狀態</th>
            <th nowrap>使用者動作</th>
            <th nowrap>管理動作</th>
        </tr>
        </thead>
        <tbody>
        <?php $i =1; ?>
        @foreach($classrooms as $classroom)
        <tr>
            <td>
                {{ $i }}
            </td>
            <td>
                {{ $classroom->name }}
            </td>
            <td>
                @if($classroom->disable)
                    <p class="text-danger">停用</p>
                @else
                    <p class="text-success">啟用</p>
                @endif
            </td>
            <td>
                @if($classroom->disable)
                    <p class="text-danger"><i class="fas fa-times-circle"></i> 禁用</p>
                @else
                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-check-circle"></i> 預約</a>
                @endif

            </td>
            <td>
                <a href="#" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 修改</a>
                <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $classroom->id }}','確定刪除？')"><i class="fas fa-trash"></i> 刪除</a>
            </td>
            {{ Form::open(['route' => ['classrooms.destroy',$classroom->id], 'method' => 'DELETE','id'=>'delete'.$classroom->id,'onsubmit'=>'return false;']) }}
            {{ Form::close() }}
        </tr>
        <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
@extends('layouts.master')

@section('page-title', '指定管理')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-trophy"></i> 指定管理</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">指定列表</li>
        </ol>
    </nav>
    <a href="{{ route('funs.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增指定模組管理</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>序號</th>
            <th>類別</th>
            <th>管理者</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $i=1;
            $fun_type = config('app.fun_type');
        ?>
        @foreach($funs as $fun)
           <tr>
               <td>
                {{ $i }}
               </td>
               <td>
                   {{ $fun_type[$fun->type] }}
               </td>
               <td>
                    {{ $fun->user->name }}({{ $fun->user->username }})
               </td>
               <td>
                   <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $fun->id }}','確定刪除？')"><i class="fas fa-trash"></i> 刪除</a>
               </td>
           </tr>
            {{ Form::open(['route' => ['funs.destroy',$fun->id], 'method' => 'DELETE','id'=>'delete'.$fun->id,'onsubmit'=>'return false;']) }}
            {{ Form::close() }}
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
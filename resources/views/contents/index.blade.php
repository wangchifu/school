@extends('layouts.master')

@section('page-title', '內容管理')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-file-alt"></i> 內容管理</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">內容列表</li>
        </ol>
    </nav>
    <a href="{{ route('contents.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增內容</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>id</th>
            <th>標題</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($contents as $content)
            <tr>
                <td>{{ $content->id }}</td>
                <td><a href="{{ route('contents.show',$content->id) }}" target="_blank">{{ $content->title }}</a></td>
                <td>
                    <a href="{{ route('contents.edit',$content->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 修改</a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $content->id }}','當真要刪除？')"><i class="fas fa-trash"></i> 刪除</a>
                </td>
            </tr>
            {{ Form::open(['route' => ['contents.destroy',$content->id], 'method' => 'DELETE','id'=>'delete'.$content->id,'onsubmit'=>'return false;']) }}
            {{ Form::close() }}
        @endforeach
        </tbody>
    </table>
</div>
@endsection
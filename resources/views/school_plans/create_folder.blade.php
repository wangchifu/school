@extends('layouts.master')

@section('page-title', '新增公告 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1>新增公告</h1>
    <a href="{{ route('open_files.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-5">
            {{ Form::open(['route' => 'open_files.store_folder', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            @include('groups.folder_form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')

@section('page-title', '使用者-群組列表')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-users"></i> 使用者-群組列表 [ {{ $group->name }} ]</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">帳號列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $group->name }}列表管理</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <table class="table table-striped">
            <thead class="thead-light">
            <tr>
                <th>序號</th>
                <th>帳號</th>
                <th>姓名</th>
                <th>職稱</th>
                <th>在職狀況</th>
                <th>動作</th>
            </tr>
            </thead>
            <tbody>
            <?php $i =1; ?>
            @foreach($user_data as $k=>$v)
                <tr>
                    <td>
                        {{ $i }}
                    </td>
                    <td>
                        {{ $v['username'] }}
                    </td>
                    <td>
                        {{ $v['name'] }}
                    </td>
                    <td>
                        {{ $v['job_title'] }}
                    </td>
                    <td>
                        @if($v['disable'])
                            <strong class="text-danger">已離職</strong>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $v['id'] }}','確定離開？')">離開群組</a>
                    </td>
                    {{ Form::open(['route' => 'users_groups.destroy', 'method' => 'DELETE','id'=>'delete'.$v['id'],'onsubmit'=>'return false;']) }}
                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                    <input type="hidden" name="user_id" value="{{ $v['id'] }}">
                    {{ Form::close() }}
                </tr>
                <?php $i++; ?>
            @endforeach
            </tbody>
        </table>
        </div>

        <div class="col-md-3">
            {{ Form::open(['route' => 'users_groups.store', 'method' => 'POST','id'=>'add','onsubmit'=>'return false;']) }}
            {{ Form::select('user_id[]', $user_menu,null, ['id' => 'user_id', 'class' => 'form-control','multiple'=>'multiple','size'=>'20', 'placeholder' => '---可多選---']) }}
            <br>
            <a href="#" class="btn btn-success" onclick="bbconfirm_Form('add','確定加入？')"><i class="fas fa-plus"></i> 加入使用者</a>
            <input type="hidden" name="group_id" value="{{ $group->id }}">
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
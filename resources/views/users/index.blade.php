@extends('layouts.master')

@section('page-title', '使用者列表 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-user"></i> 使用者列表</h1>
    <a href="{{ route('users.allEdit') }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 大量修改</a>
    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增使用者</a>
    <br><br>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>序號</th>
            <th>帳號</th>
            <th>排序</th>
            <th>姓名</th>
            <th>職稱</th>
            <th>群組</th>
            <th>在職狀況</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        <?php $i =1; ?>
        @foreach($users as $user)
            <tr>
                <td>
                    {{ $i }}
                </td>
                <td>
                    {{ $user->username }}
                </td>
                <td>
                    {{ $user->order_by }}
                </td>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->job_title }}
                </td>
                <td>
                    @foreach($user->groups as $group)
                        {{ $group->group->name }}
                    @endforeach
                </td>
                <td>
                    @if($user->disable)
                        <strong class="text-danger">已離職</strong>
                    @endif
                </td>
                <td>
                    <a href="#" class="btn btn-secondary btn-sm" onclick="bbconfirm_Form('resetPw{{ $user->id }}','還原密碼為預設？')"><i class="fas fa-undo"></i> 還原密碼</a>
                    <a href="{{ route('users.edit',$user->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 修改</a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $user->id }}','當真要刪除？')"><i class="fas fa-trash"></i> 刪除</a>
                </td>
            </tr>
            <?php $i++; ?>
            {{ Form::open(['route' => ['users.destroy',$user->id], 'method' => 'DELETE','id'=>'delete'.$user->id,'onsubmit'=>'return false;']) }}
            {{ Form::close() }}
            {{ Form::open(['route' => ['users.resetPw',$user->id], 'method' => 'PATCH','id'=>'resetPw'.$user->id,'onsubmit'=>'return false;']) }}
            {{ Form::close() }}
        @endforeach
        </tbody>
    </table>
</div>
@endsection
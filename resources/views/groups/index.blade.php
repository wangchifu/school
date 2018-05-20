@extends('layouts.master')

@section('page-title', '群組列表 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-users"></i> 群組列表</h1>
    <a href="{{ route('groups.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增群組</a>
    <br><br>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>序號</th>
            <th>名稱</th>
            <th>所屬人數</th>
            <th>停用?</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        <?php $i =1; ?>
        @foreach($groups as $group)
            <tr>
                <td>
                    {{ $i }}
                </td>
                <td>
                    {{ $group->name }}
                </td>
                <th>
                    @if(!empty($user_group_data[$group->id]))
                        {{ count($user_group_data[$group->id]) }}
                    @else
                        0
                    @endif
                    <a href="{{ route('users_groups',$group->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                </th>
                <td>
                    @if($group->disable)
                        <strong class="text-danger">已停用</strong>
                    @endif
                </td>
                <td>
                    @if($group->id > 3)
                        <a href="{{ route('groups.edit',$group->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 修改</a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $group->id }}','當真要刪除？')"><i class="fas fa-trash"></i> 刪除</a>
                    @else
                        內定群組
                    @endif
                </td>
            </tr>
            <?php $i++; ?>
            {{ Form::open(['route' => ['groups.destroy',$group->id], 'method' => 'DELETE','id'=>'delete'.$group->id,'onsubmit'=>'return false;']) }}
            {{ Form::close() }}
        @endforeach
        </tbody>
    </table>
</div>
@endsection
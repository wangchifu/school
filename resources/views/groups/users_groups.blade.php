@extends('layouts.master')

@section('page-title', '使用者-群組列表 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-users"></i> 使用者-群組列表 [ {{ $group->name }} ]</h1>
    <a href="{{ route('groups.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <br><br>
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
            {{ Form::select('user_id[]', $user_menu,null, ['id' => 'user_id', 'class' => 'form-control','multiple'=>'multiple', 'placeholder' => '---可多選---']) }}
            <br>
            <a href="#" class="btn btn-success" onclick="bbconfirm_Form('add','確定加入？')"><i class="fas fa-plus"></i> 加入使用者</a>
            <input type="hidden" name="group_id" value="{{ $group->id }}">
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
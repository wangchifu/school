@extends('layouts.master')

@section('page-title', '大量修改使用者')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-user"></i> 大量修改帳號</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">帳號列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">大量修改</li>
        </ol>
    </nav>
    {{ Form::open(['route' => 'users.allUpdate', 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
    <a href="#" class="btn btn-primary btn-sm" onclick="bbconfirm_Form('setup','確定儲存嗎？')"><i class="fas fa-save"></i> 送出修改</a>
    <br>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>序號</th>
            <th>姓名</th>
            <th>排序</th>
            <th>職稱</th>
            <th>群組</th>
        </tr>
        </thead>
        <tbody>
        <?php $i =1; ?>.
        @foreach($users as $user)
            <tr>
                <td>
                    {{ $i }}
                </td>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ Form::text('order_by[]',$user->order_by,['id'=>'order_by','class' => 'form-control', 'placeholder' => '排序']) }}
                </td>
                <td>
                    {{ Form::text('job_title[]',$user->job_title,['id'=>'job_title','class' => 'form-control', 'placeholder' => '職稱']) }}
                </td>
                <td>
                    @foreach($user->groups as $group)
                        {{ $group->group->name }}
                    @endforeach
                </td>
            </tr>
            <?php $i++; ?>
            <input type="hidden" name="user_id[]" value="{{ $user->id }}">
        @endforeach
        </tbody>
    </table>
    <a href="#" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')"><i class="fas fa-save"></i> 送出修改</a>
    {{ Form::close() }}
</div>
@endsection
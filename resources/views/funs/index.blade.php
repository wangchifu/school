@extends('layouts.master')

@section('page-title', '指定管理 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1>指定管理</h1>
    <a href="{{ route('funs.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增指定模組管理</a>
    <br><br>
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
        <?php $i=1;?>
        @foreach($funs as $fun)
           <tr>
               <td>
                {{ $i }}
               </td>
               <td>
                   @if($fun->type == "1")
                       <p class="text-primary">報修系統</p>
                   @elseif($fun->type == "2")
                       <p class="text-info">午餐系統</p>
                   @else
                       <p class="text-success">運動會報名系統</p>
                   @endif
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
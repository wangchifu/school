@extends('layouts.master')

@section('page-title', '連結管理')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-link"></i> 連結管理</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">連結列表</li>
        </ol>
    </nav>
    <a href="{{ route('links.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增連結</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>序號</th>
            <th>類別</th>
            <th>名稱</th>
            <th>網址</th>
            <th>排序</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=0;$j=0; ?>
        @foreach($links as $link)
            <?php
            if($link->type == "1") $i++;
            if($link->type == "2") $j++;
            ?>
           <tr>
               <td>
                   @if($link->type == "1")
                       {{ $i }}
                   @else
                       {{ $j }}
                   @endif
               </td>
               <td>
                   @if($link->type == "1")
                       <p class="text-primary">校內網站</p>
                   @else
                       <p class="text-danger">校外系統</p>
                   @endif
               </td>
               <td>
                   {{ $link->name }}
               </td>
               <td>
                   <a href="{{ $link->url }}" target="_blank"><i class="fas fa-globe"></i></a>

               </td>
               <td>
                   {{ $link->order_by }}
               </td>
               <td>
                   <a href="{{ route('links.edit',$link->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 修改</a>
                   <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $link->id }}','確定刪除？')"><i class="fas fa-trash"></i> 刪除</a>
               </td>
           </tr>
            {{ Form::open(['route' => ['links.destroy',$link->id], 'method' => 'DELETE','id'=>'delete'.$link->id,'onsubmit'=>'return false;']) }}
            {{ Form::close() }}
        @endforeach
        </tbody>
    </table>
</div>
@endsection
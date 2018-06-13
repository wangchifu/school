@extends('layouts.master')

@section('page-title', '午餐設定')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 午餐設定</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item active" aria-current="page">午餐設定</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['setup'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    @if($admin)
    <a href="{{ route('lunch_setups.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增學期設定</a>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>學期</th>
            <th>教職員訂餐設定</th>
            <th>師生退餐設定</th>
            <th>管理動作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lunch_setups as $lunch_setup)
            <tr>
                <td>
                    {{ $lunch_setup->semester }}
                </td>
                <td nowrap>
                    @if($lunch_setup->tea_open)
                    <strong class="text-danger">隨時可訂(請盡速關閉)</strong>
                    @else
                        <strong class="text-success">上一個月前 {{ $lunch_setup->die_line }} 天</strong>
                    @endif
                </td>
                <td>
                    @if($lunch_setup->tea_open)
                        <strong class="text-danger">期末結算，師生停止退餐</strong>
                    @else
                        <strong class="text-success">前 {{ $lunch_setup->die_line }} 天可退餐</strong>
                    @endif
                </td>
                <td>
                    <a href="{{ route('lunch_setups.edit',$lunch_setup->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 修改</a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $lunch_setup->id }}','當真要刪除學期設定？')"><i class="fas fa-trash"></i> 刪除</a>
                </td>
                {{ Form::open(['route' => ['lunch_setups.destroy',$lunch_setup->id], 'method' => 'DELETE','id'=>'delete'.$lunch_setup->id,'onsubmit'=>'return false;']) }}
                {{ Form::close() }}
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $lunch_setups->links() }}
    @else
        <h1 class="text-danger">你不是管理者</h1>
    @endif
</div>
@endsection
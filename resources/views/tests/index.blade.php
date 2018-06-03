@extends('layouts.master')

@section('page-title', '問卷系統 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-check-square"></i> 問卷系統</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">問卷系統</li>
        </ol>
    </nav>
    @can('create',\App\Test::class)
    <a href="{{ route('tests.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增問卷</a>
    @endcan
    <table class="table table-striped">
        <thead>
            <tr>
                <th nowrap width="60">序號</th>
                <th nowrap>問 卷 名 稱</th>
                <th nowrap width="100">對 象</th>
                <th nowrap>狀態</th>
                <th nowrap width="110">截止日期</th>
                <th nowrap>建立者</th>
                <th nowrap>使用者動作</th>
                <th nowrap width="300">管理動作<small>(停用才能增加題目)</small></th>
            </tr>
        </thead>
        <tbody>
        <?php  $i = 1; ?>
        @foreach($tests as $test)
                <?php
                if($test->do != "0"){
                    $check_right = \App\UserGroup::where('user_id',auth()->user()->id)
                        ->where('group_id',$test->do)
                        ->first();
                    $has_right = (!empty($check_right))?"1":"0";
                }else{
                    $has_right = "1";
                }
                if($test->user_id == auth()->user()->id) $has_right = "1";

                $answer_done = \App\Answer::where('user_id',auth()->user()->id)->where('test_id',$test->id)->first();
                $has_done = (empty($answer_done))?"0":"1";

                ?>
                @if($has_right)
                <tr>
                    <td>
                        {{ $i }}
                    </td>
                    <td>
                        {{ $test->name }}
                    </td>
                    <td>
                        {{ $groups[$test->do] }}
                    </td>
                    <td>
                        @if($test->disable == null)
                            <p class="text-success">啟用</p>
                        @else
                            <p class="text-danger">停用</p>
                        @endif
                    </td>
                    <td>
                        @if(str_replace('-','',$test->unpublished_at) < date('Ymd'))
                            <p class="text-danger">{{ $test->unpublished_at }}</p>
                        @else
                            <p class="text-success">{{ $test->unpublished_at }}</p>
                        @endif
                    </td>
                    <td>
                        {{ $test->user->name }}
                    </td>
                    <td>
                        @if(str_replace('-','',$test->unpublished_at) < date('Ymd') or $test->disable != null)
                            @if($has_done)
                                <a href="{{ route('tests.re_input',$test->id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i> 已填</a>
                            @else
                                <a href="#" class="btn btn-dark btn-sm"><i class="fas fa-times-circle"></i> 禁止</a>
                            @endif
                        @else
                            @if($has_done)
                                <a href="{{ route('tests.re_input',$test->id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i> 已填</a>
                            @else
                                <a href="{{ route('tests.input',$test->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> 填寫</a>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($test->user_id == auth()->user()->id)
                            <a href="{{ route('answers.show',$test->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> 閱</a>
                            @if($test->disable == "1")
                                <a href="{{ route('questions.index',$test->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-plus-circle"></i> 題</a>
                            @endif
                            <a href="{{ route('tests.edit',$test->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pen-square"></i> 修</a>
                                <a href="{{ route('tests.copy',$test->id) }}" class="btn btn-outline-primary btn-sm" id="copy{{ $test->id }}" onclick="bbconfirm_Link('copy{{ $test->id }}','當真要複製？請記得更改問卷名稱及截止日期喔！')"><i class="fas fa-copy"></i> 複</a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $test->id }}','確定刪除？')"><i class="fas fa-trash"></i> 刪</a>
                            {{ Form::open(['route' => ['tests.destroy',$test->id], 'method' => 'DELETE','id'=>'delete'.$test->id,'onsubmit'=>'return false;']) }}
                            {{ Form::close() }}
                        @endif
                    </td>
                </tr>
                @endif
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
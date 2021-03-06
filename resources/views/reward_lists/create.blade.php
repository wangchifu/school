@extends('layouts.master')

@section('page-title', '新增獎狀填報項目')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-check-square"></i> 新增獎狀填報項目</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">獎狀填報列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增獎狀填報項目</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card my-4">
                <div class="card-header">
                    <h3>獎狀填報：{{ $reward->name }}</h3>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'reward_lists.copy', 'method' => 'POST','id'=>'copy']) }}
                    <table>
                        <tr>
                            <td>
                                從
                            </td>
                            <td>
                                {{ Form::select('from_reward_id', $rewards,null, ['id' => 'reward_id', 'class' => 'form-control','required'=>'required','placeholder' => '請選擇']) }}
                            </td>
                            <td>
                                複製
                            </td>
                            <td>
                                　　
                            </td>
                            <td>
                                <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('確定複製？')"><i class="fas fa-copy"></i> 執行項目複製</button>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="reward_id" value="{{ $reward->id }}">
                    {{ Form::close() }}
                    @include('layouts.alert')
                    {{ Form::open(['route' => 'reward_lists.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="100">
                                <strong class="text-danger">順序*</strong>
                            </th>
                            <th>
                                <strong class="text-danger">獎項*</strong>
                            </th>
                            <th>
                                <strong class="text-danger">獎狀內文</strong>
                                <small class="text-primary">(如：<span class="text-danger">{班級}</span> <span class="text-danger">{姓名}</span> 同學<span class="text-danger">{換行}</span>一百零六學年度第一學期<span class="text-danger">{換行}</span>畢業考學業評量，成績優異，表現傑出。希望你繼續努力，爭取更高榮譽。)</small>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="reward_id" value="{{ $reward->id }}">
                                {{ Form::text('order_by', null, ['id' => 'order', 'class' => 'form-control', 'placeholder' => '序號','required'=>'required']) }}
                            </td>
                            <td>
                                {{ Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'placeholder' => '請輸入項目','required'=>'required']) }}
                            </td>
                            <td>
                                {{ Form::text('description', null, ['id' => 'description', 'class' => 'form-control', 'placeholder' => '請填內容']) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <button class="btn btn-success" onclick="bbconfirm_Form('store','確定新增題目？')"><i class="fas fa-save"></i> 儲存</button>
                            </td>
                        </tr>
                        @foreach($reward_lists as $reward_list)
                        <tr>
                            <td>
                                <a href="{{ route('reward_lists.destroy',$reward_list->id) }}" onclick="return confirm('會連已填報的資料一起刪喔！')">
                                    <i class="fas fa-times-circle text-danger"></i>
                                </a>
                                {{ $reward_list->order_by }}
                            </td>
                            <td>
                                {{ $reward_list->title }}
                            </td>
                            <td>
                                {{ $reward_list->description }}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
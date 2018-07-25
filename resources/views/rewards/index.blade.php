@extends('layouts.master')

@section('page-title', '定期評量獎狀')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-certificate"></i> 定期評量獎狀</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">獎狀填報列表</li>
        </ol>
    </nav>
    @can('create',\App\Post::class)
        <a href="{{ route('rewards.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增獎狀填報</a>
    @endcan
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>
                序號
            </th>
            <th>
                標題
            </th>
            <th>
                動作
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1; ?>
        @foreach($rewards as $reward)
            <?php
                $lists = [];
                foreach($reward->reward_lists as $reward_list){
                    $lists[$reward_list->order_by][$reward_list->id]['id'] = $reward_list->id;
                    $lists[$reward_list->order_by][$reward_list->id]['title'] = $reward_list->title;
                    $lists[$reward_list->order_by][$reward_list->id]['description'] = $reward_list->description;
                    $lists[$reward_list->order_by][$reward_list->id]['user_id'] = $reward_list->reward->user_id;
                }
                ksort($lists);
            ?>
        <tr>
            <td>
                {{ $i }}
            </td>
            <td>
                @if($reward->disable == 1)
                    <i class="fas fa-ban text-danger"></i> {{ $reward->name }}
                @else
                    <i class="fas fa-check-circle text-success"></i>
                    <a href="{{ route('winners.create',$reward) }}">{{ $reward->name }}</a>
                @endif
                @if(!empty($reward->description))
                <small class="text-primary">({{ $reward->description }})</small>
                @endif
            </td>
            <td>
                @if($reward->user_id == auth()->user()->id)
                    <a href="{{ route('reward_lists.create',$reward->id) }}" class="btn btn-info btn-sm"><i class="fas fa-plus-circle"></i> 新增填報項目</a>
                    @if($reward->disable)
                        <a href="{{ route('rewards.disable',$reward) }}" class="btn btn-warning btn-sm"><i class="fas fa-hand-paper"></i> 已停用</a>
                    @else
                        <a href="{{ route('rewards.disable',$reward) }}" class="btn btn-success btn-sm"><i class="fas fa-play"></i> 已啟用</a>
                    @endif
                    <a href="{{ route('rewards.destroy',$reward->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('相關資料一併刪除？')"><i class="fas fa-trash"></i> 刪除</a>
                @endif

            </td>
        </tr>
        <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
    {{ $rewards->links() }}
</div>
@endsection
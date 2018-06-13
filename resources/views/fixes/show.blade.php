@extends('layouts.master')

@section('page-title', '報修內容')

@section('content')
<br><br>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mt-4"><i class="fas fa-wrench"></i> {{ $fix->title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fixes.index') }}">報修列表</a></li>
                    <li class="breadcrumb-item active" aria-current="page">報修內容</li>
                </ol>
            </nav>
            <p class="lead">
                <?php
                $s=['1'=>'處理完畢','2'=>'處理中','3'=>'申報中'];
                $icon = [
                    '1'=>'<i class="fas fa-check-square text-success"></i>',
                    '2'=>'<i class="fas fa-exclamation-triangle text-warning"></i>',
                    '3'=>'<i class="fas fa-phone-square text-danger"></i>'
                ];
                ?>
                {!! $icon[$fix->situation] !!} {{ $s[$fix->situation] }}

                張貼者 {{ $fix->user->name }}</a>
                @if(($fix->user_id == auth()->user()->id and $fix->created_at == $fix->updated_at) or $fix_admin == 1)
                <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $fix->id }}','當真要刪除？')"><i class="fas fa-trash"></i> 刪除</a>
                {{ Form::open(['route' => ['fixes.destroy',$fix->id], 'method' => 'DELETE','id'=>'delete'.$fix->id,'onsubmit'=>'return false;']) }}
                {{ Form::close() }}
                @endif
            </p>
            <hr>
            <p>
                張貼日期： {{ $fix->created_at }}　　　
            </p>
            <hr>
            <div style="border:2px #ccc solid;border-radius:10px;background-color:#eee;padding:10px;">
                <p style="font-size: 1.2rem;" >
                    <?php $content = str_replace(chr(13) . chr(10), '<br>', $fix->content);?>
                        {!! $content !!}
                </p>
            </div>
            <hr>
            @if(!empty($fix->reply))
                    <?php $reply = str_replace(chr(13) . chr(10), '<br>', $fix->reply);?>
                <h4 class="text-danger">管理員回復：</h4>
                <p style="font-size: 1.2rem;" class="text-danger">
                    {!! $reply !!}
                </p>
            @endif
            @if($fix_admin)
                {{ Form::open(['route' => ['fixes.update',$fix->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
                <div class="card my-4">
                    <h3 class="card-header">管理員回應</h3>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="situation">處理狀況*</label>
                            <?php $situation=['2'=>'處理中','1'=>'處理完畢']; ?>
                            {{ Form::select('situation', $situation,null, ['id' => 'situation', 'class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label for="reply"><strong>回復*</strong></label>
                            {{ Form::textarea('reply', null, ['id' => 'reply', 'class' => 'form-control', 'rows' => 5, 'placeholder' => '請輸入內容']) }}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                                <i class="fas fa-save"></i> 儲存設定
                            </button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            @endif
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')

@section('page-title', '填寫問卷')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-check-square"></i> {{ $test->name }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tests.index') }}">問卷系統</a></li>
            <li class="breadcrumb-item active" aria-current="page">填寫問卷</li>
        </ol>
    </nav>
    {{ Form::open(['route' => 'answers.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
    @include('layouts.alert')
    @foreach($questions as $k=>$v)
    <div class="form-group">
        <label for="answer{{ $k }}">
            <strong>{{ $k }}. {{ $v['title'] }}</strong>
            @if(!empty($v['description']))
                <small class="text-primary">({{ $v['description'] }})</small>
            @endif
        </label>
        @if($v['type']=="radio")
            <?php $radio = unserialize($v['content']); ?>
            @foreach($radio as $k2=>$v2)
                <div class="form-group">
                    <div class="form-check">
                        {{ Form::radio('answer['.$v['id'].']',$v2,null,['class'=>'form-check-input','id'=>'answer'.$k.'-'.$k2]) }}
                        <label class="form-check-label" for="answer{{ $k }}-{{$k2}}"><span class="btn btn-info btn-sm">{{ $v2 }}</span></label>
                    </div>
                </div>
            @endforeach
        @endif
        @if($v['type']=="checkbox")
            <?php $checkbox = unserialize($v['content']); ?>
            @foreach($checkbox as $k2=>$v2)
                <div class="form-group">
                    <div class="form-check">
                        {{ Form::checkbox('answer['.$v['id'].'][]',$v2,null,['class'=>'form-check-input','id'=>'answer'.$k.'-'.$k2]) }}
                        <label class="form-check-label" for="answer{{ $k }}-{{$k2}}"><span class="btn btn-info btn-sm">{{ $v2 }}</span></label>
                    </div>
                </div>
            @endforeach
        @endif
        @if($v['type']=="text")
            {{ Form::text('answer['.$v['id'].']',null,['class' => 'form-control','id'=>'answer'.$k]) }}
        @endif
        @if($v['type']=="textarea")
            {{ Form::textarea('answer['.$v['id'].']',null,['class' => 'form-control','id'=>'answer'.$k]) }}
        @endif
    </div>
    @endforeach


    <button type="reset" class="btn btn-dark btn-sm"><i class="fas fa-undo"></i> 重寫</button>
    <br>
    <br>
    <input type="hidden" name="test_id" value="{{ $test->id }}">
    {{ Form::close() }}
    @if(!empty($questions))
    <a href="#" class="btn btn-primary" onclick="bbconfirm_Form('store','確定送出？')"><i class="fas fa-save"></i> 儲存答案</a>
    @endif
</div>

@endsection
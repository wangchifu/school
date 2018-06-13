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
    <a href="{{ route('answers.destroy',$test->id) }}" class="btn btn-danger btn-sm" id="destroy" onclick="bbconfirm_Link('destroy','要刪除？當你沒填？')"><i class="fas fa-trash"></i> 刪除此份答案</a>
    {{ Form::open(['route' => 'answers.update', 'method' => 'PATCH','id'=>'update','onsubmit'=>'return false;']) }}
    @include('layouts.alert')
    @foreach($questions as $k=>$v)
        <?php
        $readonly = false;
        if(str_replace('-','',$test->unpublished_at) < date('Ymd') or $test->disable != null){
            if($v['type'] == "radio" or $v['type']=="checkbox"){
                $readonly = "disabled";
            }else{
                $readonly = "readonly";
            }
        }
        ?>
        <div class="form-group">
            <label for="answer{{ $k }}">
                <strong>{{ $k }}. {{ $v['title'] }}</strong>
                @if(!empty($v['description']))
                    <small class="text-primary">({{ $v['description'] }})</small>
                @endif
            </label>
        @if($v['type']=="radio")
            <?php
            $radio = unserialize($v['content']); ?>
            @foreach($radio as $k2=>$v2)
                <?php
                    $radio_def = ($v2 == $v['answer'])?"1":"";
                ?>
                <div class="form-group">
                    <div class="form-check">
                        {{ Form::radio('answer['.$v['id'].']',$v2,$radio_def,['class'=>'form-check-input','id'=>'answer'.$k.'-'.$k2,'disabled'=>$readonly]) }}
                        <label class="form-check-label" for="answer{{ $k }}-{{$k2}}"><span class="btn btn-info btn-sm">{{ $v2 }}</span></label>
                    </div>
                </div>
            @endforeach
        @endif
        @if($v['type']=="checkbox")
            <?php $checkbox = unserialize($v['content']); ?>
            @foreach($checkbox as $k2=>$v2)
                    <?php
                    $check_def = (strstr($v['answer'],$v2))?"1":"";
                    ?>
                <div class="form-group">
                    <div class="form-check">
                        {{ Form::checkbox('answer['.$v['id'].'][]',$v2,$check_def,['class'=>'form-check-input','id'=>'answer'.$k.'-'.$k2,'disabled'=>$readonly]) }}
                        <label class="form-check-label" for="answer{{ $k }}-{{$k2}}"><span class="btn btn-info btn-sm">{{ $v2 }}</span></label>
                    </div>
                </div>
            @endforeach
        @endif
        @if($v['type']=="text")
            {{ Form::text('answer['.$v['id'].']',$v['answer'],['class' => 'form-control','readonly'=>$readonly,'id'=>'answer'.$k]) }}
        @endif
        @if($v['type']=="textarea")
            {{ Form::textarea('answer['.$v['id'].']',$v['answer'],['class' => 'form-control','readonly'=>$readonly,'id'=>'answer'.$k]) }}
        @endif
        </div>
    @endforeach
    <input type="hidden" name="test_id" value="{{ $test->id }}">
    {{ Form::close() }}
    @if(!$readonly)
    <a href="#" class="btn btn-primary btn-sm" onclick="bbconfirm_Form('update','確定修改？')"><i class="fas fa-save"></i> 儲存答案</a>
    @endif
</div>
@endsection
@extends('layouts.master')

@section('page-title', '填寫問卷 | 和東國小')

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
    {{ Form::open(['route' => 'answers.update', 'method' => 'PATCH','id'=>'update','onsubmit'=>'return false;']) }}
    @include('layouts.alert')
    <table class="table table-light">
        @foreach($questions as $k=>$v)
            <tr>
                <td>
                    <dt>{{ $k }}. {{ $v['title'] }}</dt>
                    @if(!empty($v['description']))
                        <small class="text-primary">({{ $v['description'] }})</small>
                    @endif
                </td>
                <td>
                    @if($v['type']=="radio")
                        <?php
                        $radio = unserialize($v['content']); ?>
                        @foreach($radio as $k2=>$v2)
                            <?php
                                $radio_def = ($v2 == $v['answer'])?"1":"";
                            ?>
                            <div class="form-group">
                                <div class="form-check">
                                    {{ Form::radio('answer['.$v['id'].']',$v2,$radio_def,['class'=>'form-check-input','id'=>'answer'.$k.'-'.$k2]) }}
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
                                    {{ Form::checkbox('answer['.$v['id'].'][]',$v2,$check_def,['class'=>'form-check-input','id'=>'answer'.$k.'-'.$k2]) }}
                                    <label class="form-check-label" for="answer{{ $k }}-{{$k2}}"><span class="btn btn-info btn-sm">{{ $v2 }}</span></label>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if($v['type']=="text")
                        {{ Form::text('answer['.$v['id'].']',$v['answer'],['class' => 'form-control']) }}
                    @endif
                    @if($v['type']=="textarea")
                        {{ Form::textarea('answer['.$v['id'].']',$v['answer'],['class' => 'form-control']) }}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    <input type="hidden" name="test_id" value="{{ $test->id }}">
    {{ Form::close() }}
    <a href="#" class="btn btn-primary" onclick="bbconfirm_Form('update','確定修改？')"><i class="fas fa-save"></i> 儲存答案</a>
</div>
@endsection
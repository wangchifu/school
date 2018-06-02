@extends('layouts.master')

@section('page-title', '題目管理 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-check-square"></i> [ {{ $test->name }} ] 題目管理</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tests.index') }}">問卷系統</a></li>
            <li class="breadcrumb-item active" aria-current="page">題目管理</li>
        </ol>
    </nav>
    @can('create',\App\Test::class)
    <a href="{{ route('questions.create',$test->id) }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增題目</a>
    @endcan
    <table class="table table-light">
        <thead>
            <tr>
                <th width="120">題號</th>
                <th>題目</th>
                <th width="500">作答選項</th>
            </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
        <tr>
            <td>
                <p>第 {{ $question->order_by }} 題</p>
                {{ Form::open(['route' => ['questions.destroy',$question->id], 'method' => 'DELETE','id'=>'delete'.$question->id,'onsubmit'=>'return false;']) }}
                <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $question->id }}','刪除題目[ {{ $question->order_by }} ]？')"><i class="fas fa-minus-square"></i></a>
                {{ Form::close() }}
            </td>
            <td>
                <p> {{ $question->title }}</p>
                @if($question->description)
                <small class="text-primary">({{ $question->description }})</small>
                @endif
            </td>
            <td>
                @if($question->type == "text")
                    <strong>單行文字：</strong>
                    <input name="Q{{ $question->id }}" type="{{ $question->type }}" class="form-control" placeholder="單行文字">
                @elseif($question->type == "radio")
                    <?php
                    $items = unserialize($question->content);
                    ?>
                    <strong>單選：</strong>
                    @foreach($items as $k=>$v)
                        <div class="form-group">
                            <div class="form-check">
                                <input id="q{{ $question->id }}{{ $k }}" class="form-check-input" name="Q{{ $question->id }}" type="radio" value="1">
                                <label class="form-check-label" for="q{{ $question->id }}{{ $k }}">{{ $v }}</label>
                            </div>
                        </div>
                    @endforeach
                @elseif($question->type == "checkbox")
                    <?php
                    $items = unserialize($question->content);
                    ?>
                    <strong>多選：</strong>
                    @foreach($items as $k=>$v)
                        <div class="form-group">
                            <div class="form-check">
                                <input id="q{{ $question->id }}{{ $k }}" class="form-check-input" name="Q{{ $question->id }}[]" type="checkbox" value="1">
                                <label class="form-check-label" for="q{{ $question->id }}{{ $k }}">{{ $v }}</label>
                            </div>
                        </div>
                    @endforeach
                @elseif($question->type == "textarea")
                    <strong>多行文字：</strong>
                    <textarea name="Q{{ $question->id }}" class="form-control" placeholder="第一行&#X0a;第二行"></textarea>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
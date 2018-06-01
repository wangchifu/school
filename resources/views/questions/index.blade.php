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
    <br><br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>題號</th>
                <th>題目</th>
                <th>作答選項</th>
            </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
        <tr>
            <td>
                {{ $question->order }}
            </td>
            <td>
                <dt> {{ $question->title }}</dt><br>
                <div class="text-primary">({{ $question->description }})</div>
            </td>
            <td>
                @if($question->type == "text")
                    <input name="Q{{ $question->id }}" type="{{ $question->type }}" class="form-control">
                @elseif($question->type == "radio" or  $question->type == "checkbox")
                    <?php
                    $items = explode("\r\n",$question->content);
                    ?>
                    @foreach($items as $k=>$v)
                        <input name="Q{{ $question->id }}[]" type="{{ $question->type }}" style="zoom:150%;"> {{ $v }}<br>
                    @endforeach
                @elseif($question->type == "textarea")
                    <textarea name="Q{{ $question->id }}" class="form-control"></textarea>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
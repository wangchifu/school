@extends('layouts.master')

@section('page-title', '新增問卷題目 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-check-square"></i> 新增問卷題目</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tests.index') }}">問卷系統首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('questions.index',$test->id) }}">題目管理</a></li>
            <li class="breadcrumb-item active" aria-current="page">新增題目</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card my-4">
                <div class="card-header">
                    <h3>問卷：{{ $test->name }}</h3>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'questions.store', 'method' => 'POST']) }}
                    <table class="table table-striped">
                        <thead><th>題號*</th><th>題目*</th><th>說明</th><th>題型*</th></thead>
                        <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="test_id" value="{{ $test->id }}">
                                {{ Form::text('order', null, ['id' => 'order', 'class' => 'form-control', 'placeholder' => '請輸入題號','required'=>'required']) }}
                            </td>
                            <td>
                                {{ Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'placeholder' => '請輸入題目','required'=>'required']) }}
                            </td>
                            <td>
                                {{ Form::text('description', null, ['id' => 'description', 'class' => 'form-control', 'placeholder' => '請輸入題目說明']) }}
                            </td>
                            <td>
                                <?php
                                $types = [
                                    'text'=>'1.文字填空',
                                    'radio'=>'2.單選題',
                                    'checkbox'=>'3.多選題',
                                    'textarea'=>'4.多行文字',
                                ];
                                ?>
                                {{ Form::select('type',$types, null, ['id' => 'type', 'class' => 'form-control', 'placeholder' => '選擇題型','required'=>'required']) }}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4">選項(「選擇題」才須要填)</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{ Form::textarea('content', null, ['id' => 'content', 'class' => 'form-control', 'rows' => 4, 'placeholder' => '請一行一行打上選項']) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="text-right"><button class="btn btn-success">新增題目</button></div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
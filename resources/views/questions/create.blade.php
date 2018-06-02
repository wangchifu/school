@extends('layouts.master')

@section('page-title', '新增問卷題目 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-check-square"></i> 新增問卷題目</h1>
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
                    @include('layouts.alert')
                    {{ Form::open(['route' => 'questions.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
                    <table class="table table-striped">
                        <thead><th width="100">題號*</th><th>題目*</th><th>說明</th><th>題型*</th></thead>
                        <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="test_id" value="{{ $test->id }}">
                                {{ Form::text('order_by', null, ['id' => 'order', 'class' => 'form-control', 'placeholder' => '題號','required'=>'required']) }}
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
                                    'radio'=>'1.單選題',
                                    'checkbox'=>'2.多選題',
                                    'text'=>'3.單行文字',
                                    'textarea'=>'4.多行文字',
                                ];
                                ?>
                                {{ Form::select('type',$types, null, ['id' => 'type', 'class' => 'form-control','onchange'=>'show_type(this);', 'placeholder' => '選擇題型','required'=>'required']) }}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4">選項(選擇題必填)</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div id='show_type' style="display:none">
                                    <p>
                                        <label for='var1'>選項1：</label>
                                        <input type='text' name='option[]' id='var1'>
                                    </p>
                                    <p>
                                        <label for='var2'>選項2：</label>
                                        <input type='text' name='option[]' id='var2'>
                                        <i class='fas fa-plus-circle text-success' onclick="add()"></i>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div><button class="btn btn-success" onclick="bbconfirm_Form('store','確定新增題目？')">新增題目</button></div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var c = 2;
    function show_type(G) {
        if(G.value == 'radio' || G.value == 'checkbox'){
            $("#show_type").show();
        } else {
            $("#show_type").hide();
        }
    }

    function add() {
        var content;
        c++;
        content = "<p>" +
            "<label for='var"+c+"'>選項"+c+"：</label>" +
            "<input type='text' name='option[]' id='var"+c+"'> " +
            "<i class='fas fa-trash text-danger' onclick='remove(this)'></i>" +
            "</p>";
        $("#show_type").append(content);
    }

    function remove(obj) {
        $(obj).parent().remove();
        c--;
    }

</script>

@endsection
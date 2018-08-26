@extends('layouts.master')

@section('page-title', '期初學生更改訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 期初學生更改訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">期初學生更改訂餐</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['special'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    <div class="card">
        <div class="card-header">
            <h2>期初學生更改訂餐</h2>
            <h2 class="text-danger">(非期初切勿操作)</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.change_stu_begin_store', 'method' => 'POST','id'=>'change','onsubmit'=>'return false;']) }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        班級座號5碼
                    </th>
                    <th>
                        用餐別
                    </th>
                    <th>
                        身份別
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" name="class_num" class="form-control" maxlength="5">
                    </td>
                    <td>
                        <input type='radio' name='eat_style' value='1' id="eat1" checked><label for="eat1"><span class="btn btn-danger btn-sm">葷食</span></label>　
                        <input type='radio' name='eat_style' value='2' id="eat2"><label for="eat2"><span class="btn btn-success btn-sm">素食</span></label>　
                        <input type='radio' name='eat_style' value='3' id="eat3"><label for="eat3"><span class="btn btn-dark btn-sm">不訂</span></label>
                    </td>

                    <td>
                        <?php
                        $selects = [
                            '101'=>"101-----一般生",
                            '201'=>"201-----弱勢生-----低收入戶",
                            '202'=>"202-----弱勢生-----中低收入戶",
                            '203'=>"203-----弱勢生-----家庭突發因素",
                            '204'=>"204-----弱勢生-----父母一方失業",
                            '205'=>"205-----弱勢生-----單親家庭",
                            '206'=>"206-----弱勢生-----隔代教養",
                            '207'=>"207-----弱勢生-----特殊境遇",
                            '208'=>"208-----弱勢生-----身心障礙學生",
                            '209'=>"209-----弱勢生-----新住民子女",
                            '210'=>"210-----弱勢生-----原住民子女",
                        ];
                        ?>
                        {{ Form::select('p_id', $selects, null, ['id' => 'p_id', 'class' => 'form-control']) }}
                    </td>
                </tr>
                </tbody>
            </table>
            <button class="btn btn-info" id="b_submit" onclick="bbconfirm_Form('change','你確定你知道你在做什麼？')">更改學生期初訂餐</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

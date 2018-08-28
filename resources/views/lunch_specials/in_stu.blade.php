@extends('layouts.master')

@section('page-title', '轉入學生訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 轉入學生訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">轉入學生訂餐</li>
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
            <h2>轉入學生訂餐</h2>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.in_stu_store', 'method' => 'POST','id'=>'change','onsubmit'=>'return false;']) }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        學號6碼
                    </th>
                    <th>
                        班級座號5碼
                    </th>
                    <th>
                        姓名
                    </th>
                    <th>
                        性別
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" name="sn" class="form-control" maxlength="6">
                    </td>
                    <td>
                        <input type="text" name="class_num" class="form-control" maxlength="5">
                    </td>
                    <td>
                        <input type="text" name="name" class="form-control">
                    </td>
                    <td>
                        <input type='radio' name='sex' value='1' id="sex1" checked> <label for="sex1"><span class="btn btn-primary btn-sm">男</span></label>　
                        <input type='radio' name='sex' value='2' id="sex2"> <label for="sex2"><span class="btn btn-danger btn-sm">女</span></label>　
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        哪一天開始用餐
                    </th>
                    <th>
                        葷素
                    </th>
                    <th>
                        身份別
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ Form::select('order_date', $date_data,null, ['id' => 'order_date', 'class' => 'form-control']) }}
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
            <button class="btn btn-success" id="b_submit" onclick="bbconfirm_Form('change','你確定你知道你在做什麼？')">更改</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

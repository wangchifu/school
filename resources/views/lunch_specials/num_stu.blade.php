@extends('layouts.master')

@section('page-title', '學生更改座號')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 學生更改座號</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">學生更改座號</li>
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
            <h2>學生更改座號</h2>
            <p>座號的更改會影響午餐的資料配對，不可不慎！</p>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'lunch_specials.num_stu_store', 'method' => 'POST','id'=>'change','onsubmit'=>'return false;']) }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        學號6碼
                    </th>
                    <th>
                        新班級座號5碼
                    </th>
                    <th>
                        姓名
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" name="sn" class="form-control" maxlength="6">
                    </td>
                    <td>
                        <input type="text" name="student_num" class="form-control" maxlength="5">
                    </td>
                    <td>
                        <input type="text" name="name" class="form-control">
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

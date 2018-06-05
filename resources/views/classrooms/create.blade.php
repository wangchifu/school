@extends('layouts.master')

@section('page-title', '新增教室 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-warehouse"></i> 新增教室</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classroom_orders.index') }}">教室預約</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classrooms.index') }}">教室管理</a></li>
        <li class="breadcrumb-item active" aria-current="page">新增教室</li>
    </ol>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            {{ Form::open(['route' => 'classrooms.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            <?php
                $disable=null;
                $sections = array('0','1','2','3','4','45','5','6','7');
                for($i=0;$i<7;$i++){
                    foreach($sections as $v){
                        $close[$i][$v] = null;
                    }
                }
                $close[0][0] = 1;
                $close[0][1] = 1;
                $close[0][2] = 1;
                $close[0][3] = 1;
                $close[0][4] = 1;
                $close[0][45] = 1;
                $close[0][5] = 1;
                $close[0][6] = 1;
                $close[0][7] = 1;
                $close[6][0] = 1;
                $close[6][1] = 1;
                $close[6][2] = 1;
                $close[6][3] = 1;
                $close[6][4] = 1;
                $close[6][45] = 1;
                $close[6][5] = 1;
                $close[6][6] = 1;
                $close[6][7] = 1;
            ?>
            @include('classrooms.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
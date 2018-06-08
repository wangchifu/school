@extends('layouts.master')

@section('page-title', '新增教室 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-warehouse"></i> 新增教室</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classroom_orders.index') }}">教室預約列表</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classrooms.index') }}">教室管理</a></li>
        <li class="breadcrumb-item active" aria-current="page">新增教室</li>
    </ol>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            {{ Form::open(['route' => 'classrooms.store', 'method' => 'POST','id'=>'setup','onsubmit'=>'return false;']) }}
            <?php
                $name=null;
                $disable=null;
                $sections = config("app.class_sections");
                for($i=0;$i<7;$i++){
                    foreach($sections as $k=>$v){
                        $close[$i][$k] = null;
                        if($k=="45" or $k=="0" or $i=="0" or $i=="6"){
                            $close[$i][$k] = 1;
                        }
                    }
                }
            ?>
            @include('classrooms.form')
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
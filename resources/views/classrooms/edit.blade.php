@extends('layouts.master')

@section('page-title', '編輯教室 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-warehouse"></i> 編輯教室</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classroom_orders.index') }}">教室預約列表</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classrooms.index') }}">教室管理</a></li>
        <li class="breadcrumb-item active" aria-current="page">編輯教室</li>
    </ol>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            {{ Form::open(['route' => ['classrooms.update',$classroom->id], 'method' => 'PATCH','id'=>'setup','onsubmit'=>'return false;']) }}
            <?php
                $name=$classroom->name;
                $disable=$classroom->disable;

                $sections = array('0','1','2','3','4','45','5','6','7');
                for($i=0;$i<7;$i++){
                    foreach($sections as $v){
                        $close[$i][$v] = null;
                        if(strpos($classroom->close_sections, "'".$i."-".$v."'") !== false){
                            $close[$i][$v] = 1;
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
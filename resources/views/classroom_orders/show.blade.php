@extends('layouts.master')

@section('page-title', '教室預約')

@section('content')


    <br><br><br>
    <div class="container">
        <h1><i class="fas fa-warehouse"></i> 預約教室查詢</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classroom_orders.index') }}">教室預約列表</a></li>
                <li class="breadcrumb-item active" aria-current="page">預約教室查詢</li>
            </ol>
        </nav>
        <h2>{{ $classroom->name }}</h2>
        <?php
        $cht_week = config("app.cht_week");
        $class_sections = config("app.class_sections");
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <td rowspan="2">
                    <h3><a href="{{ route('classroom_orders.show',['classroom_id'=>$classroom->id,'select_sunday'=>$last_sunday]) }}"><i class="fas fa-arrow-alt-circle-left"></i></a></h3>
                </td>
                @foreach($week as $k => $v)
                    <?php
                        $font="";
                        $bg="";
                    if($k=="0"){
                        $font="text-danger";
                        $bg = "red";
                    }
                    if($k=="6"){
                        $font="text-success";
                        $bg = "green";
                    }
                    ?>
                <td>
                    <span class="{{ $font }}">{{ $cht_week[$k] }}</span>
                </td>
                @endforeach
                <td rowspan="2">
                    <h3><a href="{{ route('classroom_orders.show',['classroom'=>$classroom->id,'select_sunday'=>$next_sunday]) }}"><i class="fas fa-arrow-alt-circle-right"></i></a></h3>
                </td>
            </tr>
            <tr>
                @foreach($week as $k => $v)
                    <?php
                    $font="";
                    if($k=="0"){
                        $font="text-danger";
                    }
                    if($k=="6"){
                        $font="text-success";
                    }
                    ?>
                    <?php $class = ($v==date('Y-m-d'))?"btn btn-info btn-sm":""; ?>
                    <td>
                        <span class="{{ $class }} {{ $font }}">{{ $v }}</span>
                    </td>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($class_sections as $k1=>$v1)
            <tr>
                <td>{{ $v1 }}</td>
                @foreach($week as $k2 => $v2)
                <td>
                    @if(empty($has_order[$v2][$k1]['id']))
                        @if(strpos($classroom->close_sections, "'".$k2."-".$k1."'") !== false)
                            -
                        @else
                            <a href="{{ route('classroom_orders.select',['classroom_id'=>$classroom->id,'section'=>$k1,'order_date'=>$v2]) }}"
                               class="btn btn-secondary btn-sm"
                               id="s{{ $k1 }}{{ $k2 }}" onclick="bbconfirm_Link('s{{ $k1 }}{{ $k2 }}','確定預約{{ $classroom->name }} {{ $v2 }} {{ $v1 }}')">
                                <i class="fas fa-check-circle"></i> 選我</a>
                        @endif
                    @else
                        {{ $has_order[$v2][$k1]['user_name'] }}
                        @if(auth()->user()->id == $has_order[$v2][$k1]['id'])
                            <a href="#" onclick="bbconfirm_Form('delete{{ $k1 }}{{ $k2 }}','確定刪除 {{ $classroom->name }} {{ $v2 }} {{ $v1 }} 的預約？')"><i class="fas fa-times-circle text-danger"></i></a>
                            {{ Form::open(['route' => 'classroom_orders.destroy', 'method' => 'DELETE','id'=>'delete'.$k1.$k2,'onsubmit'=>'return false;']) }}
                            <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                            <input type="hidden" name="order_date" value="{{ $v2 }}">
                            <input type="hidden" name="section" value="{{ $k1 }}">
                            {{ Form::close() }}
                        @endif
                    @endif
                </td>
                @endforeach
                <td></td>
            </tr>
            @endforeach
            </tbody>
        </table>



    </div>

@endsection
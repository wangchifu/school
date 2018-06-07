@extends('layouts.master')

@section('page-title', '教室預約 | 和東國小')

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
        <table class="table table-striped">
            <thead>
            <tr>
                <th>

                </th>
                @foreach($week as $k => $v)
                    <?php
                        $font="";
                        $bg="";
                    if($k=="日"){
                        $font="text-danger";
                        $bg = "red";
                    }
                    if($k=="六"){
                        $font="text-success";
                        $bg = "green";
                    }
                    ?>
                <th>
                    <span class="{{ $font }}">{{ $k }}</span>
                </th>
                @endforeach
                <th>

                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>

                </td>
                @foreach($week as $k => $v)
                    <?php
                    $font="";
                    if($k=="日"){
                        $font="text-danger";
                    }
                    if($k=="六"){
                        $font="text-success";
                    }
                    ?>
                    <?php $class = ($v==date('Y-m-d'))?"btn btn-info btn-sm":""; ?>
                    <td>
                        <span class="{{ $class }} {{ $font }}">{{ $v }}</span>
                    </td>
                @endforeach
                <td>
                </td>
            </tr>
            <?php $ws = ['0'=>'晨　間','1'=>'第一節','2'=>'第二節','3'=>'第三節','4'=>'第四節','45'=>'午　休','5'=>'第五節','6'=>'第六節','7'=>'第七節']; ?>
            @foreach($ws as $k=>$v)
            <tr>
                <td>{{ $v }}</td>
                @foreach($week as $k => $v)
                <td>
                    <a href="#" class="btn btn-success btn-sm">預約</a>
                </td>
                @endforeach
                <td></td>
            </tr>
            @endforeach
            </tbody>
        </table>



    </div>

@endsection
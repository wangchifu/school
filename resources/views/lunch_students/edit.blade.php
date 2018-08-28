@extends('layouts.master')

@section('page-title', '學生訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 學生訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item active" aria-current="page">學生訂餐</li>
        </ol>
    </nav>
    <?php
        foreach(config('app.lunch_page') as $v){
            $active[$v] = "";
        }
        $active['student'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    @if($admin)
        {{ Form::open(['route' => 'lunch_students.change_tea', 'method' => 'POST']) }}
        管理員：<input type="text" name="class_id" maxlength="3" placeholder="班級代碼"> <button class="btn btn-success btn-sm">送出</button>
        <input type="hidden" name="page" value="order">
        {{ Form::close() }}
    @endif
    <h2>{{ $class_id }}班的訂餐資料(已訂)</h2>
    <h2 class="text-danger">欲修改請洽管理員</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th nowrap>座號</th><th>姓名</th><th>葷素食</th><th>學生身份</th><th nowrap>座號</th><th>姓名</th><th nowrap>速看</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stu_data as $k=>$v)
            @if($v['sex']==1)
                <?php $color="text-primary";$icon="boy.gif"; ?>
            @elseif($v['sex']==2)
                <?php $color="text-danger";$icon="girl.gif"; ?>
            @endif
            <?php
            $out = ($v['out_in'] == "out")?"<span class='btn btn-warning btn-sm'>轉出</span>":"";
            $in = ($v['out_in'] == "in")?"<span class='btn btn-info btn-sm'>轉入</span>":"";
            ?>
            <tr>
                <td>{{ $k }}</td>
                <td><img src="{{ asset('img/'.$icon) }}"><span class="{{ $color }}">{{ $v['name'] }}</span>{!! $out !!}{!! $in !!}</td>
                <td>
                    @if($order_data[$v['id']]['eat_style']=="1")
                        <span class="btn btn-danger btn-sm" >葷食</span><img src="{{ asset('img/meat.png') }}" width="16">
                    @elseif($order_data[$v['id']]['eat_style']=="2")
                        <span class="btn btn-success btn-sm">素食</span><img src="{{ asset('img/vegetarian.png') }}" width="16">
                    @elseif($order_data[$v['id']]['eat_style']=="3")
                        <span class="btn btn-dark btn-sm">不訂</span><img src="{{ asset('img/no_check.png') }}" width="16">
                    @endif
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
                    {{ $selects[$order_data[$v['id']]['p_id']] }}
                </td>
                <td>{{ $k }}</td>
                <td><span class="{{ $color }}">{{ $v['name'] }}</span></td>
                <td>
                    @if($order_data[$v['id']]['eat_style']=="2")
                    <img src="{{ asset('img/lettuce.png') }}"">
                    @endif
                    @if($order_data[$v['id']]['p_id'] > 200)
                    <img src="{{ asset('img/face_smile.png') }}">
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h2 class="text-danger">欲修改請洽管理員</h2>

</div>
@endsection
@extends('layouts.master')

@section('page-title', '學生訂餐報表')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 學生訂餐報表</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">報表輸出</li>
            <li class="breadcrumb-item active" aria-current="page">學生訂餐報表</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['report'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    {{ Form::open(['route' => 'lunch_reports.stu', 'method' => 'POST']) }}
    請先選擇餐期：{{ Form::select('order_id', $orders, $order_id, ['id' => 'order_id', 'class' => 'form-control', 'placeholder' => '請先選擇餐期','onchange'=>'if(this.value != 0) { this.form.submit(); }']) }}
    {{ Form::close() }}
    <hr>
    <div class="card">
        <div class="card-header">
            <h2>各班訂餐資訊</h2>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        班級
                    </th>
                    <th>
                        訂餐數
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($stu_data as $k=>$v)
                    <tr>
                        <td>
                            {{ $k }}
                        </td>
                        <td>
                            {{ $v }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

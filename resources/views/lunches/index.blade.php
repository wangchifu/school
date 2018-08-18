@extends('layouts.master')

@section('page-title', '教職員訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 教職員訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item active" aria-current="page">教職員訂餐</li>
        </ol>
    </nav>
    <?php
        foreach(config('app.lunch_page') as $v){
            $active[$v] = "";
        }
        $active['teacher'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    <h4>{{ auth()->user()->name }} 的訂餐資料</h4>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>學期</th>
            <th>教職餐價</th>
            <th>供餐日數</th>
            <th>月份</th>
            <th>總收費</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lunch_setups as $lunch_setup)
            <?php
            $order_dates = \App\LunchOrderDate::where('semester',$lunch_setup->semester)->where('enable','1')->get();
            $orders = \App\LunchOrder::where('semester',$lunch_setup->semester)->get();
            ?>
        <tr>
            <td>
                {{ $lunch_setup->semester }}
            </td>
            <th>
                {{ $lunch_setup->tea_money }}
            </th>
            <td>
                {{ count($order_dates) }}
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                            月份
                        </td>
                        <td>
                            訂餐數
                        </td>
                        <td>
                            收費
                        </td>
                    </tr>
                <?php $total_money=0; ?>
                @foreach($orders as $order)
                    <?php
                        $lunch_order = \App\LunchOrder::where('name',$order->name)->first();
                        $lunch_tea_orders = \App\LunchTeaDate::where('lunch_order_id',$lunch_order->id)
                        ->where('user_id',auth()->user()->id)
                        ->where('enable','1')
                        ->get();
                    ?>
                        <tr>
                            <td>
                                {{ $order->name }}
                            </td>
                            <td>
                                {{ count( $lunch_tea_orders) }} 次
                            </td>
                            <td>
                                {{ count( $lunch_tea_orders) * $lunch_setup->tea_money }} 元
                            </td>
                        </tr>
                    <?php
                        $total_money += count( $lunch_tea_orders) * $lunch_setup->tea_money;
                    ?>
                @endforeach
                </table>
            </td>
            <td>
                {{ $total_money }} 元
            </td>
            <td>
                @if($lunch_setup->semester ==get_semester())
                    @if($total_money == 0)
                        <a href="{{ route('lunches.create',$lunch_setup->semester) }}" class="btn btn-success btn-sm">我要訂餐</a>
                    @else
                        <a href="{{ route('lunches.edit',$lunch_setup->semester) }}" class="btn btn-primary btn-sm">訂餐管理</a>
                    @endif

                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $lunch_setups->links() }}
</div>
@endsection
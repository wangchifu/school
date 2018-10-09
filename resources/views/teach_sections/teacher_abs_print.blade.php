@extends('layouts.master_print')

@section('page-title', '教學組-代課課表')

@section('content')
<br><br><br>
<div class="container">
    <h2 class="text-center">{{ $title }}</h2>
        <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th nowrap>
                姓名
            </th>
            <th nowrap>
                上課期間
            </th>
            <th nowrap>
                請假者
            </th>
            <th nowrap>
                請假事由
            </th>
            <th nowrap>
                節數
            </th>
            <th nowrap>
                鐘點費
            </th>
            <th nowrap>
                請領金額
            </th>
            <th nowrap>
                請領合計
            </th>
            <th nowrap>
                勞保
            </th>
            <th nowrap>
                2代健保自付補充
            </th>
            <th nowrap>
                實領金額
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
            $all_sections = 0;
            $all_ori_money = 0;
            $all_ori_total_money = 0;
            $all_laubo = 0;
            $all_zenbo = 0;
            $all_real_money = 0;
        ?>
        @foreach($sub_tea as $k=>$v)
            @foreach($v as $k1=>$v1)
            <tr>
                <td>
                    {{ $sub_tea[$k][$k1] }}
                </td>
                <td>
                    {{ $abs_date[$k][$k1] }}
                </td>
                <td>
                    {{ $ori_tea[$k][$k1] }}
                </td>
                <td>
                    {{ $ps[$k][$k1] }}
                </td>
                <td>
                    {{ $section[$k][$k1] }}
                    <?php $all_sections += $section[$k][$k1]; ?>
                </td>
                <td>
                    {{ $money }}
                </td>
                <td>
                    {{ $section[$k][$k1]*$money }}
                    <?php $all_ori_money += $section[$k][$k1]*$money; ?>
                </td>
                @if($k1==1)
                    <td rowspan="{{ count($sub_tea[$k]) }}">
                        {{ $ori_total_money[$k] }}
                        <?php $all_ori_total_money += $ori_total_money[$k]; ?>
                    </td>
                    <td rowspan="{{ count($sub_tea[$k]) }}">
                        {{ $laubo[$k] }}
                        <?php $all_laubo += $laubo[$k]; ?>
                    </td>
                    <td rowspan="{{ count($sub_tea[$k]) }}">
                        {{ $zenbo[$k] }}
                        <?php $all_zenbo += $zenbo[$k]; ?>
                    </td>
                    <td rowspan="{{ count($sub_tea[$k]) }}">
                        {{ $real_money[$k] }}
                        <?php $all_real_money += $real_money[$k]; ?>
                    </td>
                @endif
            </tr>
            @endforeach
        @endforeach
        <tr>
            <td>
                合計
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>
                {{ $all_sections }}
            </td>
            <td>

            </td>
            <td>
                {{ $all_ori_money }}
            </td>
            <td>
                {{ $all_ori_total_money }}
            </td>
            <td>
                {{ $all_laubo }}
            </td>
            <td>
                {{ $all_zenbo }}
            </td>
            <td>
                {{ $all_real_money }}
            </td>
        </tr>
        </tbody>
        </table>
        <div class="row">
            <div class="col-2">制表：</div>
            <div class="col-2">出納組長：</div>
            <div class="col-2">教務主任：</div>
            <div class="col-2">人事主任：</div>
            <div class="col-2">會計主任：</div>
            <div class="col-2">校長：</div>
        </div>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-2">保險：</div>
        </div>
</div>
@endsection
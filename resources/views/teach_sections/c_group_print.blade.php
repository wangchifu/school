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
                每週節數
            </th>
            <th nowrap>
                合計節數
            </th>
            <th nowrap>
                鐘點費
            </th>
            <th nowrap>
                請領金額
            </th>
            <th nowrap>
                勞保自付
            </th>
            <th nowrap>
                健保自付
            </th>
            <th nowrap>
                勞退自付
            </th>
            <th nowrap>
                實領金額
            </th>
            <th nowrap>
                備註
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
            $all_sections = 0;
            $all_ori_money = 0;
            $all_laubo = 0;
            $all_zenbo = 0;
            $all_laute = 0;
            $all_real_money = 0;
        ?>
        @foreach($tea as $k=>$v)
            <tr>
                <td>
                    {{ $tea[$k] }}
                </td>
                <td>
                    {{ $set_date }}
                </td>
                <td>
                    {{ $section[$k] }}
                </td>
                <td>
                    {{ $total_sections[$k] }}
                    <?php $all_sections += $total_sections[$k]; ?>
                </td>
                <td>
                    {{ $money }}
                </td>
                <td>
                    {{ $ori_money[$k] }}
                    <?php $all_ori_money += $ori_money[$k]; ?>
                </td>
                <td>
                    {{ $laubo[$k] }}
                    <?php $all_laubo += $laubo[$k]; ?>
                </td>
                <td>
                    {{ $zenbo[$k] }}
                    <?php $all_zenbo += $zenbo[$k]; ?>
                </td>
                <td>
                    {{ $laute[$k] }}
                    <?php $all_laute += $laute[$k]; ?>
                </td>
                <td>
                    {{ $real_money[$k] }}
                    <?php $all_real_money += $real_money[$k]; ?>
                </td>
                <td>
                    {{ $ps[$k] }}
                </td>
            </tr>
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
                {{ $all_sections }}
            </td>
            <td>

            </td>
            <td>
                {{ $all_ori_money }}
            </td>
            <td>
                {{ $all_laubo }}
            </td>
            <td>
                {{ $all_zenbo }}
            </td>
            <td>
                {{ $all_laute }}
            </td>
            <td>
                {{ $all_real_money }}
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">
                健保補充保費機關負擔款 1.91 %
            </td>
            <td>
                {{ round($all_ori_money*0.0191) }}
            </td>
            <td rowspan="2">
                備註
            </td>
            <td rowspan="2" colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5">
                鐘點費及健保補充保費機關負擔款
            </td>
            <td>
                {{ $all_ori_money + round($all_ori_money*0.0191)}}
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
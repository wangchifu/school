@extends('layouts.master_print2')

@section('page-title', '教學組-代課課表')

@section('content')
<script src="{{ asset('gijgo/js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css">
<br><br><br>
<div class="container">
    <h1>輔導團月結報表-步驟二</h1>
        {{ Form::open(['route'=>'c_group.send_report','method'=>'POST']) }}
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
        @foreach($ori_subs as $ori_sub)
            <?php
            $ori_teacher = \APP\User::where('id',$ori_sub->ori_teacher)->first();
            $sub_teacher = \APP\User::where('id',$ori_sub->sub_teacher)->first();
            ?>
        <tr>
            <td nowrap>
                {{ $sub_teacher->name }}
            </td>
            <td nowrap>
                {{ substr($start_date,5,5) }}~{{ substr($stop_date,5,5) }}
            </td>
            <td>
                {{ $ori_sub->section }}
            </td>
            <td>

            </td>
            <td>
                {{ Form::text('money',null,['class' => 'form-control', 'required' => 'required']) }}
            </td>
            <td>

            </td>
            <td>
                {{ Form::text('laubo',null,['class' => 'form-control', 'required' => 'required']) }}
            </td>
            <td>
                {{ Form::text('zenbo',null,['class' => 'form-control', 'required' => 'required']) }}
            </td>
            <td>
                {{ Form::text('laute',null,['class' => 'form-control', 'required' => 'required']) }}
            </td>
            <td>

            </td>
            <td nowrap>
                {{ $ori_sub->ps }}
            </td>
        </tr>
        @endforeach
        </tbody>
        </table>
        <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> 填好列印</button>
        {{ Form::close() }}

</div>
@endsection
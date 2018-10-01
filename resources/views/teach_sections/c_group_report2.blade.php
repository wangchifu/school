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
            <th nowrap width="120">
                姓名
            </th>
            <th nowrap width="160">
                上課期間
            </th>
            <th nowrap>
                每週節數
            </th>
            <th nowrap>
                合計節數
            </th>
            <th nowrap width="90">
                鐘點費
            </th>
            <th nowrap width="110">
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
            <th nowrap width="110">
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
                <input type="text" name="tea[{{ $ori_sub->id }}]" value="{{ $sub_teacher->name }}" class="form-control" readonly>
            </td>
            <td nowrap>
                <input type="text" name="set_date[{{ $ori_sub->id }}]" value="{{ substr($start_date,5,5) }}~{{ substr($stop_date,5,5) }}" class="form-control" readonly>
            </td>
            <td>
                <input type="text" name="section[{{ $ori_sub->id }}]" value="{{ $ori_sub->section }}" class="form-control" readonly>
            </td>
            <td>
                <input type="text" name="total_sections[{{ $ori_sub->id }}]" id="total_sections{{ $ori_sub->id }}" value="{{ $total_sections[$ori_sub->id] }}" class="form-control" readonly>
            </td>
            <td>
                {{ Form::text('money',$money,['class' => 'form-control', 'readonly' => 'readonly']) }}
            </td>
            <td>
                <?php
                    $ori_money = $money*$total_sections[$ori_sub->id];
                ?>
                <input type="text" name="ori_money{{ $ori_sub->id }}" id="ori_money{{ $ori_sub->id }}" class="form-control" value="{{ $ori_money }}" readonly>
            </td>
            <td>
                {{ Form::text('laubo['.$ori_sub->id.']',0,['id'=>'laubo'.$ori_sub->id,'class' => 'form-control','onchange'=>'change_real'.$ori_sub->id.'(this)']) }}
            </td>
            <td>
                {{ Form::text('zenbo['.$ori_sub->id.']',0,['id'=>'zenbo'.$ori_sub->id,'class' => 'form-control','onchange'=>'change_real'.$ori_sub->id.'(this)']) }}
            </td>
            <td>
                {{ Form::text('laute['.$ori_sub->id.']',0,['id'=>'laubote'.$ori_sub->id,'class' => 'form-control','onchange'=>'change_real'.$ori_sub->id.'(this)']) }}
            </td>
            <td>
                <?php
                    $real_money = $ori_money;
                ?>
                {{ Form::text('real_money['.$ori_sub->id.']',$real_money,['id'=>'real_money'.$ori_sub->id,'class' => 'form-control', 'readonly' => 'readonly']) }}
            </td>
            <td nowrap>
                {{ $ori_sub->ps }}
            </td>
        </tr>
            <script>
                function change_real{{ $ori_sub->id }}(obj){
                    document.getElementById('real_money{{ $ori_sub->id }}').value=document.getElementById('ori_money{{ $ori_sub->id }}').value - obj.value;
                }
            </script>
        @endforeach
        </tbody>
        </table>
        <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> 填好列印</button>
        {{ Form::close() }}
</div>
@endsection
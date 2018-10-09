@extends('layouts.master_print2')

@section('page-title', '教學組-代課課表')

@section('content')
<br><br><br>
<div class="container">
    <h1>「請假代課」月結報表-步驟二</h1>
        {{ Form::open(['route'=>'teacher_abs.print','method'=>'POST']) }}
        <input type="text" name="title" class="form-control" value="彰化縣和東國民小學{{ $title }}" readonly>
        <br>
        <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th nowrap width="100">
                姓名
            </th>
            <th nowrap width="140">
                上課期間
            </th>
            <th nowrap width="100">
                請假者
            </th>
            <th nowrap>
                請假事由
            </th>
            <th>
                節數
            </th>
            <th>
                鐘點費
            </th>
            <th nowrap width="100">
                請領金額
            </th>
            <th nowrap width="100">
                請領合計
            </th>
            <th nowrap width="100">
                勞保
            </th>
            <th width="100">
                二代健保自付補充
            </th>
            <th nowrap width="100">
                實領金額
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($abs_data as $k=>$v)
            @foreach($v as $k1=>$v1)
            <tr>
                <td>
                    <input type="text" name="sub_tea[{{ $k }}][{{ $k1 }}]" value="{{ $v1['sub_teacher'] }}" class="form-control" readonly>
                </td>
                <td>
                    <input type="text" name="abs_date[{{ $k }}][{{ $k1 }}]" value="{{ $v1['abs_date'] }}" class="form-control" readonly>
                </td>
                <td>
                    <input type="text" name="ori_tea[{{ $k }}][{{ $k1 }}]" value="{{ $v1['ori_teacher'] }}" class="form-control" readonly>
                </td>
                <td>
                    <input type="text" name="ps[{{ $k }}][{{ $k1 }}]" value="{{ $v1['ps'] }}" class="form-control" readonly>
                </td>
                <td>
                    <input type="text" name="section[{{ $k }}][{{ $k1 }}]" value="{{ $v1['section'] }}" class="form-control" readonly>
                </td>
                <td>
                    {{ Form::text('money',$money,['class' => 'form-control', 'readonly' => 'readonly']) }}
                </td>
                <td>
                    <input type="text" name="ori_money[{{ $k }}][{{ $k1 }}]" value="{{ $v1['section']*$money }}" class="form-control" readonly>
                </td>
                @if($k1==1)
                    <td rowspan="{{ count($v) }}">
                        <input type="text" name="ori_total_money[{{ $k }}]" id="ori_money{{ $k }}" class="form-control" value="{{ $total_section[$k]*$money }}" readonly>
                    </td>
                    <td rowspan="{{ count($v) }}">
                        {{ Form::text('laubo['.$k.']',0,['id'=>'laubo'.$k,'class' => 'form-control','onchange'=>'change_real'.$k.'(this)']) }}
                    </td>
                    <td rowspan="{{ count($v) }}">
                        {{ Form::text('zenbo['.$k.']',0,['id'=>'zenbo'.$k,'class' => 'form-control','onchange'=>'change_real'.$k.'(this)']) }}
                    </td>
                    <td rowspan="{{ count($v) }}">
                        {{ Form::text('real_money['.$k.']',$total_section[$k]*$money,['id'=>'real_money'.$k,'class' => 'form-control', 'readonly' => 'readonly']) }}
                    </td>
                @endif
            </tr>
            @endforeach
            <script>
                function change_real{{ $k }}(obj){
                    document.getElementById('real_money{{ $k }}').value=document.getElementById('real_money{{ $k }}').value - obj.value;
                }
            </script>
        @endforeach
        </tbody>
        </table>
        <button type="submit" class="btn btn-primary" onclick="return confirm('確定列印？')"><i class="fas fa-print"></i> 填好列印</button>
        {{ Form::close() }}
</div>
@endsection
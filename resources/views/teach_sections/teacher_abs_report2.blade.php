@extends('layouts.master_print2')

@section('page-title', '教學組-代課課表')

@section('content')
<br><br><br>
<div class="container">
    <h1>「請假代課」月結報表-步驟二</h1>
        {{ Form::open(['route'=>'c_group.print','method'=>'POST']) }}
        <input type="text" name="title" class="form-control" value="彰化縣和東國民小學{{ $title }}" readonly>
        <br>
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
            <th nowrap width="110">
                請領金額
            </th>
            <th>
                請領合計
            </th>
            <th nowrap>
                勞保
            </th>
            <th nowrap>
                二代健保自付補充
            </th>
            <th nowrap>
                實領金額
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($abs_data as $k=>$v)
            <tr>
                <td>
                    {{ $v['sub_teacher'] }}
                </td>
                <td>
                    {{ $v['abs_date'] }}
                </td>
                <td>
                    {{ $v['ori_teacher'] }}
                </td>
                <td>
                    {{ $v['ps'] }}
                </td>
                <td>
                    {{ $v['section'] }}
                </td>
                <td>
                    {{ $money }}
                </td>
                <td>
                    {{ $v['section']*$money }}
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
        <button type="submit" class="btn btn-primary" onclick="return confirm('確定列印？')"><i class="fas fa-print"></i> 填好列印</button>
        {{ Form::close() }}
</div>
@endsection
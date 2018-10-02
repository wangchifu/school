@extends('layouts.master_print2')

@section('page-title', '教學組-代課課表')

@section('content')
<script src="{{ asset('gijgo/js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css">
<br><br><br>
<div class="container">
    <h1>輔導團月結報表-步驟二</h1>
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

        </tbody>
        </table>
</div>
@endsection
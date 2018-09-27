@extends('layouts.master')

@section('page-title', '月份設定')

@section('content')
<script src="{{ asset('gijgo/js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css">
<br><br><br>
<div class="container">
    <h1><i class="fas fa-user-times"></i> 教學組</h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#">代課.兼課.超鐘點費</a>
        </li>
    </ul>
    <hr>
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('teach_section.index') }}" class="btn btn-light">操作說明</a>
        <a href="{{ route('substitute_teacher.index') }}" class="btn btn-success">代課名單</a>
        <a href="{{ route('month_setup.index') }}" class="btn btn-info active">月份設定</a>
        <a href="{{ route('c_group.index') }}" class="btn btn-secondary">輔導團案</a>
        <a href="{{ route('support.index') }}" class="btn btn-secondary">支援教師</a>
        <a href="{{ route('taxation.index') }}" class="btn btn-secondary">課稅方案</a>
        <a href="{{ route('over.index') }}" class="btn btn-secondary">超鐘點案</a>
        <a href="#" class="btn btn-danger">請假排代</a>
        <a href="#" class="btn btn-primary">報表輸出</a>
    </div>
    <hr>
    <div class="card">
        <div class="card-header">
            <h3>月份設定</h3>
        </div>
        <div class="card-body">
            <h5><i class="fas fa-smile"></i> 不上課日</h5>
            {{ Form::open(['route' => 'month_setup.store', 'method' => 'POST']) }}
            <table class="table table-striped">
                <tr>
                    <td>
                        學期(4碼)
                    </td>
                    <td>
                        類別
                    </td>
                    <td>
                        起日
                    </td>
                    <td>
                        迄日
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ Form::text('semester',$semester,['class'=>'form-control','maxlength'=>'4','size'=>'6','required'=>'required']) }}
                    </td>
                    <td>
                        {{ Form::select('type', $types,null, ['class' => 'form-control']) }}
                    </td>
                    <td>
                        <input id="datepicker1" width="276" name="holiday1" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker1').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>
                    </td>
                    <td>
                        <input id="datepicker2" width="276" name="holiday2" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker2').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('確定送出？')">送出不上課日</button>
            {{ Form::close() }}
            <hr>
            <h5><i class="far fa-frown"></i> 補上課日</h5>
            {{ Form::open(['route' => 'month_setup.store2', 'method' => 'POST']) }}
            <table class="table table-striped">
                <tr>
                <tr>
                    <td>
                        學期(4碼)
                    </td>
                    <td>
                        哪一天補上課?
                    </td>
                    <td>
                        哪一天不上課?
                    </td>
                </tr>
                </tr>
                <tr>
                    <td>
                        {{ Form::text('semester',$semester,['class'=>'form-control','maxlength'=>'4','size'=>'6','required'=>'required']) }}
                    </td>
                    <td>
                        <input id="datepicker3" width="276" name="workday1" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker3').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>
                    </td>
                    <td>
                        <input id="datepicker4" width="276" name="workday2" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker4').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定送出？')">送出補上課日</button>
            {{ Form::close() }}
        </div>
    </div>
    <hr>
    <div class="card">
        <div class="card-header">
            <h3>{{ $semester }}學期查詢</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        狀況
                    </th>
                    <th>
                        日期
                    </th>
                    <th>
                        原因
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($month_setups as $month_setup)
                        <tr>
                            <td>
                                @if($month_setup->another_date == null)
                                    <strong class="text-info">不上課</strong>
                                @else
                                    <strong class="text-danger">補上課</strong>
                                @endif
                            </td>
                            <td>
                                {{ $month_setup->event_date }}
                                ({{ get_chinese_weekday($month_setup->event_date) }})
                            </td>
                            <td>
                                @if($month_setup->type=="winter_summer")
                                    <span class="text-success">寒(暑)假</span>
                                @elseif($month_setup->type=="holiday")
                                    <span class="text-primary">國定假日</span>
                                @elseif($month_setup->type=="typhoon")
                                    <span class="text-danger">颱風假</span>
                                @elseif($month_setup->type=="workday")
                                    <span class="text-dark">補上{{ $month_setup->another_date }}({{ get_chinese_weekday($month_setup->another_date) }})的放假</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('month_setup.destroy',$month_setup->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('確定嗎？')">刪除</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
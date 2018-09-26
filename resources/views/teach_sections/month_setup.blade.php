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
        <a href="#" class="btn btn-secondary">輔導團案</a>
        <a href="#" class="btn btn-secondary">支援教師</a>
        <a href="#" class="btn btn-secondary">課稅方案</a>
        <a href="#" class="btn btn-secondary">超鐘點案</a>
        <a href="#" class="btn btn-danger">請假排代</a>
        <a href="#" class="btn btn-primary">報表輸出</a>
    </div>
    <hr>
    <div class="card">
        <div class="card-header">
            <h3>月份設定</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <td colspan="2">
                        {{ Form::text('semester',null,['maxlength'=>'4','size'=>'6','required'=>'required']) }}
                        學期，寒(暑)假區間
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="datepicker1" width="276" name="winner_summer1" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker1').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>起
                    </td>
                    <td>
                        <input id="datepicker2" width="276" name="winner_summer2" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker2').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>迄
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('確定送出？')">送出寒(暑)假</button>
            <hr>
            <table class="table table-striped">
                <tr>
                    <td>
                        {{ Form::text('semester',null,['maxlength'=>'4','size'=>'6','required'=>'required']) }}
                        學期，在星期一~五的國定假日
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="datepicker3" width="276" name="holiday" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker3').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('確定送出？')">送出國定假日</button>
            <hr>
            <table class="table table-striped">
                <tr>
                    <td colspan="2">
                        {{ Form::text('semester',null,['maxlength'=>'4','size'=>'6','required'=>'required']) }}
                        學期，在星期六日的補上班日
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="datepicker4" width="276" name="workday1" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker4').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>補上班
                    </td>
                    <td>
                        <input id="datepicker5" width="276" name="workday2" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker5').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>放假
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定送出？')">送出補上班日</button>
            <hr>
            <table class="table table-striped">
                <tr>
                    <td>
                        {{ Form::text('semester',null,['maxlength'=>'4','size'=>'6','required'=>'required']) }}
                        學期，在星期一~五的颱風假
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="datepicker6" width="276" name="typhoon" value="{{ date('Y-m-d') }}">
                        <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
                        <script>
                            $('#datepicker6').datepicker({
                                uiLibrary: 'bootstrap4',
                                format: 'yyyy-mm-dd',
                                locale: 'zh-TW',
                            });
                        </script>
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('確定送出？')">送出颱風假</button>
        </div>
    </div>
    <hr>
    <div class="card">
        <div class="card-header">
            <h3>月份設定</h3>
        </div>
        <div class="card-body">

        </div>
    </div>
</div>
@endsection
@extends('layouts.master_clean')

@section('page-title', '教學組-代課課表')

@section('content')
<script src="{{ asset('gijgo/js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css">
<br><br><br>
<div class="container">
    <h1>「兼課教師」(課稅方案)月結報表-步驟一</h1>
    <div class="card">
        <div class="card-header">
            報表起迄
        </div>
        <div class="card-body">
            {{ Form::open(['route'=>'taxation.send_report','method'=>'POST']) }}
            <table class="table table-striped">
                <tr>
                    <td width="100">
                        學期(4碼)
                    </td>
                    <td width="120">
                        類別
                    </td>
                    <td>
                        報表名稱
                    </td>
                    <td width="100">
                        鐘點費
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
                        {{ $semester }}
                    </td>
                    <td>
                        兼課教師
                    </td>
                    <td>
                        <input type="text" name="title" class="form-control" value="107年9月兼課教師(課稅方案)鐘點費請領清冊">
                    </td>
                    <td>
                        <input type="text" name="money" class="form-control" required>
                    </td>
                    <td>
                        <input id="datepicker1" width="150" name="start_date" value="{{ date('Y-m-d') }}">
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
                        <input id="datepicker2" width="150" name="stop_date" value="{{ date('Y-m-d') }}">
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
            <button type="submit" class="btn btn-success"><i class="fas fa-play-circle"></i> 下一步</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
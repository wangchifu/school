@extends('layouts.master')

@section('page-title', '各班問題反應')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 各班問題反應</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">學生訂餐管理</li>
            <li class="breadcrumb-item active" aria-current="page">各班問題反應</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['student'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    @if($class_id)
    <div class="card">
        <div class="card-header">
            <h4>班級：{{ $class_id }}</h4>
        </div>
        <div class="card-body">
            <h2>1.不合格的，請將<img src="{{ asset('img/check.png') }}">點成<img src="{{ asset('img/no_check.png') }}"></h2>
            <table class="table table-striped">
                <tr>
                    <th>
                        日期
                    </th>
                    <th>
                        主食
                    </th>
                    <th>
                        主菜
                    </th>
                    <th>
                        副菜
                    </th>
                    <th>
                        蔬菜
                    </th>
                    <th>
                        湯品
                    </th>
                    <th>
                        不合格原因
                    </th>
                    <th>
                        廠商處置
                    </th>
                    <th>
                        動作
                    </th>
                </tr>
                <tr>
                    {{ Form::open(['route'=>'lunch_checks.store','method'=>'POST','id'=>'check_store','onsubmit'=>'return false']) }}
                    <td>
                        {{ Form::select('order_date', $order_dates,null, ['class' => 'form-control']) }}
                        <script>
                            function goChangeBg1(obj){
                                if (obj.checked == true){
                                    document.getElementById('main_eat').src="{{ asset('img/check.png') }}";
                                }else{
                                    document.getElementById('main_eat').src="{{ asset('img/no_check.png') }}";
                                }
                            }
                            function goChangeBg2(obj){
                                if (obj.checked == true){
                                    document.getElementById('main_vag').src="{{ asset('img/check.png') }}";
                                }else{
                                    document.getElementById('main_vag').src="{{ asset('img/no_check.png') }}";
                                }
                            }
                            function goChangeBg3(obj){
                                if (obj.checked == true){
                                    document.getElementById('co_vag').src="{{ asset('img/check.png') }}";
                                }else{
                                    document.getElementById('co_vag').src="{{ asset('img/no_check.png') }}";
                                }
                            }
                            function goChangeBg4(obj){
                                if (obj.checked == true){
                                    document.getElementById('vag').src="{{ asset('img/check.png') }}";
                                }else{
                                    document.getElementById('vag').src="{{ asset('img/no_check.png') }}";
                                }
                            }
                            function goChangeBg5(obj){
                                if (obj.checked == true){
                                    document.getElementById('soup').src="{{ asset('img/check.png') }}";
                                }else{
                                    document.getElementById('soup').src="{{ asset('img/no_check.png') }}";
                                }
                            }
                        </script>
                    </td>
                    <td>
                        <input type="checkbox" id="main_eat1" name="main_eat" checked onclick="goChangeBg1(this);"> <label for="main_eat1"><img id="main_eat" src="{{ asset('img/check.png') }}"></label>
                    </td>
                    <td>
                        <input type="checkbox" id="main_vag1" name="main_vag" checked onclick="goChangeBg2(this);"> <label for="main_vag1"><img id="main_vag" src="{{ asset('img/check.png') }}"></label>
                    </td>
                    <td>
                        <input type="checkbox" id="co_vag1" name="co_vag" checked onclick="goChangeBg3(this);"> <label for="co_vag1"><img id="co_vag" src="{{ asset('img/check.png') }}"></label>
                    </td>
                    <td>
                        <input type="checkbox" id="vag1" name="vag" checked onclick="goChangeBg4(this);"> <label for="vag1"><img id="vag" src="{{ asset('img/check.png') }}"></label>
                    </td>
                    <td>
                        <input type="checkbox" id="soup1" name="soup" checked onclick="goChangeBg5(this);"> <label for="soup1"><img id="soup" src="{{ asset('img/check.png') }}"></label>
                    </td>
                    <td>
                        {{ Form::text('reason',null,['id'=>'reason','class' => 'form-control', 'placeholder' => '請輸入原因','required'=>'required']) }}
                    </td>
                    <td>
                        <?php
                        $actives = [
                            "1"=>"1.已處理(移除)",
                            "2"=>"2.已更換",
                            "3"=>"3.僅目前通報",
                        ];
                        ?>
                        {{ Form::select('action', $actives, null, ['id' => 'action', 'class' => 'form-control']) }}
                    </td>
                    <td>
                        <a href="#" class="btn btn-success" onclick="bbconfirm_Form('check_store','你確定要送出嗎？')"><span class="fas fa-plus-circle"></span> 新增</a>
                    </td>
                    <input type="hidden" name="semester" value="{{ $semester }}">
                    <input type="hidden" name="class_id" value="{{ $class_id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    {{ Form::close() }}
                </tr>
                <tr>
                    <td colspan="9"><h2>2.列出本學期本班回報記錄</h2></td>
                </tr>
                @foreach($checks as $check)
                    {{ Form::open(['route'=>['lunch_checks.destroy',$check->id],'method'=>'POST','id'=>'check_destroy'.$check->id,'onsubmit'=>'return false']) }}
                    <tr>
                        <td>
                            {{ $check->order_date }}
                        </td>
                        <td>
                            @if($check->main_eat == "1")
                                <img src="{{ asset('img/no_check.png') }}">
                            @endif
                        </td>
                        <td>
                            @if($check->main_vag == "1")
                                <img src="{{ asset('img/no_check.png') }}">
                            @endif
                        </td>
                        <td>
                            @if($check->co_vag == "1")
                                <img src="{{ asset('img/no_check.png') }}">
                            @endif
                        </td>
                        <td>
                            @if($check->vag == "1")
                                <img src="{{ asset('img/no_check.png') }}">
                            @endif
                        </td>
                        <td>
                            @if($check->soup == "1")
                                <img src="{{ asset('img/no_check.png') }}">
                            @endif
                        </td>
                        <td>
                            {{ $check->reason }}
                        </td>
                        <td>
                            @if($check->action == "1")
                                已處理(移除)
                            @elseif($check->action == "2")
                                已更換
                            @elseif($check->action == "3")
                                僅目前通報
                            @endif

                        </td>
                        <td>
                            <a href="#" class="btn btn-danger" onclick="bbconfirm_Form('check_destroy{{ $check->id }}','你真的要刪除？')">刪除</a>
                        </td>
                    </tr>
                    {{ Form::close() }}
                @endforeach
            </table>
        </div>
    </div>
    <hr>
    @endif
    @if($admin)
        <div class="card">
            <div class="card-header">
                <h2>管理員：全校反應問題 <a href="{{ route('lunch_checks.print') }}" class="btn btn-secondary btn-sm" target="_blank"><i class="fas fa-print"></i> 列印本學期</a></h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>
                            班級
                        </th>
                        <th>
                            日期
                        </th>
                        <th>
                            主食
                        </th>
                        <th>
                            主菜
                        </th>
                        <th>
                            副菜
                        </th>
                        <th>
                            蔬菜
                        </th>
                        <th>
                            湯品
                        </th>
                        <th>
                            不合格原因
                        </th>
                        <th>
                            廠商處置
                        </th>
                        <th>
                            動作
                        </th>
                    </tr>
                    @foreach($admin_checks as $admin_check)
                        <tr>
                            <td>
                                {{ $admin_check->class_id }}
                            </td>
                            <td>
                                {{ $admin_check->order_date }}
                            </td>
                            <td>
                                @if($admin_check->main_eat == "1")
                                    <img src="{{ asset('img/no_check.png') }}">
                                @endif
                            </td>
                            <td>
                                @if($admin_check->main_vag == "1")
                                    <img src="{{ asset('img/no_check.png') }}">
                                @endif
                            </td>
                            <td>
                                @if($admin_check->co_vag == "1")
                                    <img src="{{ asset('img/no_check.png') }}">
                                @endif
                            </td>
                            <td>
                                @if($admin_check->vag == "1")
                                    <img src="{{ asset('img/no_check.png') }}">
                                @endif
                            </td>
                            <td>
                                @if($admin_check->soup == "1")
                                    <img src="{{ asset('img/no_check.png') }}">
                                @endif
                            </td>
                            <td>
                                {{ $admin_check->reason }}
                            </td>
                            <td>
                                @if($admin_check->action == "1")
                                    已處理(移除)
                                @elseif($admin_check->action == "2")
                                    已更換
                                @elseif($admin_check->action == "3")
                                    僅目前通報
                                @endif

                            </td>
                            <td>
                                <a href="#" class="btn btn-danger" onclick="bbconfirm_Form('check_destroy{{ $admin_check->id }}','你真的要刪除？')">刪除</a>
                            </td>
                        </tr>
                        {{ Form::close() }}
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

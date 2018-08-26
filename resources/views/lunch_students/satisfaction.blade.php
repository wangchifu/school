@extends('layouts.master')

@section('page-title', '滿意度調查')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 滿度意調查</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">學生訂餐管理</li>
            <li class="breadcrumb-item active" aria-current="page">滿意度調查</li>
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
            <table class="table table-striped">
                <tr>
                    <td>
                        學期
                    </td>
                    <td>
                        調查表
                    </td>
                    <td>
                        狀況
                    </td>
                </tr>
                @foreach($satisfactions as $satisfaction)
                    @if($satisfaction->semester == $semester)
                        <?php
                        $has_done = \App\LunchSatisfactionClass::where('lunch_satisfaction_id','=',$satisfaction->id)
                            ->where('class_id','=',$class_id)
                            ->count();
                        ?>
                        <tr>
                            <td>
                                {{ $satisfaction->semester }}
                            </td>
                            <td>
                                {{ $satisfaction->name }}
                            </td>
                            <td>
                                @if($has_done == 0)
                                    <a href="{{ route('lunch_satisfactions.show',$satisfaction->id) }}" class="btn btn-success" target="_blank">填寫</a>
                                @else
                                    <a href="{{ route('lunch_satisfactions.show_answer',$satisfaction->id) }}" class="btn btn-danger" target="_blank">已填寫</a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>
    <hr>
    @endif
    @if($admin)
        <div class="card">
            <div class="card-header">
                <h2>管理員：管理滿意度表單</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>
                            學期
                        </th>
                        <th nowrap>
                            調查表名稱
                        </th>
                        <th nowrap>
                            回報班級數
                        </th>
                        <th>
                            動作
                        </th>
                    </tr>
                    {{ Form::open(['route'=>'lunch_satisfactions.store','method'=>'POST','id'=>'satisfaction_store','onsubmit'=>'return false']) }}
                    <tr>
                        <td>
                            {{ Form::text('semester',$semester,['id'=>'semester','class' => 'form-control', 'placeholder' => '1061','required'=>'required']) }}
                        </td>
                        <td>
                            {{ Form::text('name',$semester.'第1次滿意度調查表',['id'=>'name','class' => 'form-control', 'placeholder' => '106第1次滿意度調查表','required'=>'required']) }}
                        </td>
                        <td>

                        </td>
                        <td>
                            <a href="#" class="btn btn-success" onclick="bbconfirm_Form('satisfaction_store','確定要新增調查表？')">新增</a>
                        </td>
                    </tr>
                    {{ Form::close() }}
                    @foreach($satisfactions as $satisfaction)
                        {{ Form::open(['route'=>['lunch_satisfactions.destroy',$satisfaction->id],'method'=>'POST','id'=>'satisfaction_destroy','onsubmit'=>'return false']) }}
                        <tr>
                            <td>
                                {{ $satisfaction->semester }}
                            </td>
                            <td>
                                {{ $satisfaction->name }}
                            </td>
                            <?php
                            $classes_data = \App\LunchSatisfactionClass::where('lunch_satisfaction_id','=',$satisfaction->id)->get();
                            $class_name = "已交：";
                            $num = 0;
                            foreach($classes_data as $class_data){
                                $class_name .= $class_data->class_id." , ";
                                $num++;
                            }
                            ?>
                            <td>
                                <a href="#" class="btn btn-warning" id="a{{ $satisfaction->id }}">{{ $num }}</a>
                            </td>
                            <td>
                                <a href="{{ route('lunch_satisfactions.help',$satisfaction->id) }}" class="btn btn-primary" id="help{{ $satisfaction->id }}" onclick="bbconfirm_Link('help{{ $satisfaction->id }}','確定要填滿這個調查表？')">一鍵幫填</a>
                                <a href="{{ route('lunch_satisfactions.print',$satisfaction->id) }}" class="btn btn-success" target="_blank">列印調查表</a>
                                <a href="#" class="btn btn-danger" onclick="bbconfirm_Form('satisfaction_destroy','確定要刪除這個調查表？')">刪除</a>
                            </td>
                        </tr>
                        <tr id="content{{ $satisfaction->id }}" style="display:none">
                            <td colspan="4">
                                {{ $class_name }}
                            </td>
                        </tr>
                        <script>
                            $(document).ready(function(){
                                $('#a{{ $satisfaction->id }}').click(function(){
                                    $('#content{{ $satisfaction->id }}').toggle(500);
                                });
                            });
                        </script>
                        {{ Form::close() }}
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

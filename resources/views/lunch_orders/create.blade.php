@extends('layouts.master')

@section('page-title', '午餐設定')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 供餐日設定</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item"><a href="{{ route('lunch_setups.index') }}">午餐設定</a></li>
            <li class="breadcrumb-item">供餐日設定</li>
        </ol>
    </nav>
    <br>
    @if($admin)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $semester }}學期各月份選取供餐日</h3>
                    </div>
                    <div class="card-body">
                        {{ Form::open(['route' => 'lunch_orders.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
                        @foreach($semester_dates as $k=>$v)
                            <h3>{{ $k }}</h3>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-danger">日</th>
                                    <th>一</th>
                                    <th>二</th>
                                    <th>三</th>
                                    <th>四</th>
                                    <th>五</th>
                                    <th class="text-success">六</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $first_w = get_date_w($v[1]);
                                ?>
                                <tr>
                                @foreach($v as $k2 => $v2)
                                    <?php
                                        $this_date_w = get_date_w($v2);
                                        if($this_date_w==0){
                                            $text_color = "btn btn-danger btn-sm";
                                            $checked = "";
                                        }elseif($this_date_w==6){
                                            $text_color = "btn btn-success btn-sm";
                                            $checked = "";
                                        }else{
                                            $text_color = "btn btn-outline-dark btn-sm";
                                            $checked = "checked";
                                        }
                                    ?>
                                    @if($k2 == 1)
                                        @for($i=1;$i<=$first_w;$i++)
                                            <td></td>
                                        @endfor
                                    @endif
                                        <td><input type="checkbox" name="order_date[{{ $v2 }}]" id="d{{ $v2 }}" {{ $checked }}>
                                            <label for="d{{ $v2 }}" class="{{ $text_color }}">{{ substr($v2,5,5) }}</label>
                                        </td>
                                    @if($this_date_w == 6)
                                        </tr>
                                    @endif
                                    <?php  ?>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                        @endforeach
                        <input type="hidden" name="semester" value="{{ $semester }}">
                        <a href="#" class="btn btn-success" onclick="bbconfirm_Form('store','供餐日確定？')">確定送出</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <h1 class="text-danger">你不是管理者</h1>
    @endif
</div>
@endsection
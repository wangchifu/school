@extends('layouts.master')

@section('page-title', '午餐系統')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 我要訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item"><a href="{{ route('lunches.index') }}">教職員訂餐</a></li>
            <li class="breadcrumb-item active" aria-current="page">我要訂餐</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['route' => 'lunches.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
            <div class="card">
                <div class="card-header">
                    <h3>1.訂餐資料</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <h5>1.1 選取廠商</h5>
                        <select name="factory" class="form-control">
                            @foreach($factories as $v)
                                <option value="{{ $v }}">
                                    {{ $v }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <h5>1.2 用餐葷素食別：</h5>
                        <input name="eat_style" type="radio" value="1" checked id="eat1"> <label for="eat1" class="btn btn-danger btn-sm">葷食</label>　　　
                        <input name="eat_style" type="radio" value="2" id="eat2"> <label for="eat2" class="btn btn-success btn-sm">素食</label>
                    </div>
                    <div class="form-group">
                        <h5>1.3 用餐地點：</h5>
                        <?php
                        //判斷是否為級任老師
                        $tea_class = check_tea();
                        ?>
                        @if($tea_class['class_id'])
                            <input type="text" name="place" value="{{ $tea_class['class_id'] }}" class="form-control" readonly="readonly">
                        @else
                        <select name="place" class="form-control">
                            @foreach($places as $v)
                            <option value="{{ $v }}">
                                {{ $v }}
                            </option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <div class="card">
                <div class="card-header">
                    <h3>2.請選取{{ $semester }}學期各月份的訂餐日</h3>
                </div>
                <div class="card-body">
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
                                    $checked = ($order_date_data[$v2])?"checked":"";
                                    $this_date_w = get_date_w($v2);
                                    if($this_date_w==0){
                                        $text_color = "btn btn-danger btn-sm";

                                    }elseif($this_date_w==6){
                                        $text_color = "btn btn-success btn-sm";

                                    }else{
                                        $text_color = "btn btn-outline-dark btn-sm";

                                    }
                                    ?>
                                    @if($k2 == 1)
                                        @for($i=1;$i<=$first_w;$i++)
                                            <td></td>
                                        @endfor
                                    @endif
                                    <td>
                                        @if($order_date_data[$v2] == 1)
                                        <input type="checkbox" name="order_date[{{ $v2 }}]" id="d{{ $v2 }}" {{ $checked }}>
                                        <label for="d{{ $v2 }}" class="{{ $text_color }}">{{ substr($v2,5,5) }}</label>
                                        @else
                                        <i class="fas fa-times-circle"></i>
                                        <label for="d{{ $v2 }}" class="{{ $text_color }}">{{ substr($v2,5,5) }}</label>
                                        @endif
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
                    <a href="#" class="btn btn-success" id="b_submit" onclick="bbconfirm_Form('store','你確定你的訂餐日？請不要F5重新整理！避免重複訂餐！')">確定送出</a>

                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<script>
    $("#b_submit").click(function(){
        $("#b_submit").hide();
    });
</script>
@endsection
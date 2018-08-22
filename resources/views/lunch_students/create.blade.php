@extends('layouts.master')

@section('page-title', '學生訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 學生訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item active" aria-current="page">學生訂餐</li>
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
    @if($admin)
        {{ Form::open(['route' => 'lunch_students.change_tea', 'method' => 'POST']) }}
        管理員：<input type="text" name="class_id" maxlength="3" placeholder="班級代碼"> <button class="btn btn-success btn-sm">送出</button>
        <input type="hidden" name="page" value="order">
        {{ Form::close() }}
    @endif
    @if($is_tea)
    <h4>{{ $class_id }}班的訂餐資料(未訂)</h4>
        {{ Form::open(['route' => 'lunch_students.store', 'method' => 'POST','id'=>'store','onsubmit'=>'return false;']) }}
        <table class="table table-striped">
            <thead>
            <tr>
                <th nowrap>座號</th><th>姓名</th><th>葷素食</th><th>學生身份</th><th nowrap>座號</th><th>姓名</th><th nowrap>速看</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stu_data as $k=>$v)
                <SCRIPT type='text/javascript'>
                    function goChangeBgm{{ $k }}(obj){
                        if (obj.checked == true){
                            document.imgm{{ $k }}.src='../img/meat.png';
                            document.imgg{{ $k }}.src='../img/no_color.png';
                            document.imgx{{ $k }}.src='../img/no_color.png';
                            document.quick_eat{{ $k }}.src='../img/no_color.png';

                        }
                    }
                    function goChangeBgg{{ $k }}(obj){
                        if (obj.checked == true){
                            document.imgm{{ $k }}.src='../img/no_color.png';
                            document.imgg{{ $k }}.src='../img/vegetarian.png';
                            document.imgx{{ $k }}.src='../img/no_color.png';
                            document.quick_eat{{ $k }}.src='../img/lettuce.png';

                        }
                    }
                    function goChangeBgx{{ $k }}(obj){
                        if (obj.checked == true){
                            document.imgm{{ $k }}.src='../img/no_color.png';
                            document.imgg{{ $k }}.src='../img/no_color.png';
                            document.imgx{{ $k }}.src='../img/no_check.png';
                            document.quick_eat{{ $k }}.src='../img/delete.png';
                        }
                    }
                    function goChangep{{ $k }}(obj){
                        if (obj.value >200){
                            document.quick_p{{ $k }}.src='../img/face_smile.png';
                        }else{
                            document.quick_p{{ $k }}.src='../img/no_color.png';
                        }
                    }
                </SCRIPT>
                @if($v['sex']==1)
                    <?php $color="text-primary";$icon="boy.gif"; ?>
                @elseif($v['sex']==2)
                    <?php $color="text-danger";$icon="girl.gif"; ?>
                @endif
                <tr>
                    <td>{{ $k }}</td>
                    <td><img src="{{ asset('img/'.$icon) }}"><span class="{{ $color }}">{{ $v['name'] }}</span></td>
                    <td>
                        <input type='radio' name='eat_style[{{ $v['id'] }}]' id="style1{{ $k }}" value='1' checked onclick='goChangeBgm{{ $k }}(this)' ><span class="btn btn-danger btn-sm" onclick="getElementById('style1{{ $k }}').checked='true';goChangeBgm{{ $k }}(getElementById('style1{{ $k }}'))">葷食</span><img src="{{ asset('img/meat.png') }}" name="imgm{{ $k }}" width="16">
                        <input type='radio' name='eat_style[{{ $v['id'] }}]' id="style2{{ $k }}" value='2'  onclick='goChangeBgg{{ $k }}(this)' ><span class="btn btn-success btn-sm" onclick="getElementById('style2{{ $k }}').checked='true';goChangeBgg{{ $k }}(getElementById('style2{{ $k }}'))">素食</span><img src="{{ asset('img/no_color.png') }}" name="imgg{{ $k }}" width="16">
                        <input type='radio' name='eat_style[{{ $v['id'] }}]' id="style3{{ $k }}" value='3'  onclick='goChangeBgx{{ $k }}(this)' ><span class="btn btn-dark btn-sm" onclick="getElementById('style3{{ $k }}').checked='true';goChangeBgx{{ $k }}(getElementById('style3{{ $k }}'))">不訂</span><img src="{{ asset('img/no_color.png') }}" name="imgx{{ $k }}" width="16">
                    </td>

                    <td>
                        <?php
                        $selects = [
                            '101'=>"101-----一般生",
                            '201'=>"201-----弱勢生-----低收入戶",
                            '202'=>"202-----弱勢生-----中低收入戶",
                            '203'=>"203-----弱勢生-----家庭突發因素",
                            '204'=>"204-----弱勢生-----父母一方失業",
                            '205'=>"205-----弱勢生-----單親家庭",
                            '206'=>"206-----弱勢生-----隔代教養",
                            '207'=>"207-----弱勢生-----特殊境遇",
                            '208'=>"208-----弱勢生-----身心障礙學生",
                            '209'=>"209-----弱勢生-----新住民子女",
                            '210'=>"210-----弱勢生-----原住民子女",
                        ];
                        ?>
                        {{ Form::select('p_id['.$v['id'].']', $selects, null, ['id' => 'p_id', 'class' => 'form-control','onchange'=>'goChangep'.$k.'(this)']) }}
                    </td>
                    <td>{{ $k }}</td>
                    <td><span class="{{ $color }}">{{ $v['name'] }}</span></td>
                    <td><img src="{{ asset('img/no_color.png') }}" name="quick_eat{{ $k }}"><img src="{{ asset('img/no_color.png') }}" name="quick_p{{ $k }}"></td>
                </tr>
                <input type="hidden" name="student_num[{{ $v['id'] }}]" value="{{ $class_id.$k }}">
            @endforeach
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="class_id" value="{{ $class_id }}">
            </tbody>
        </table>
        <button class="btn btn-info" id="b_submit" onclick="bbconfirm_Form('store','確定送出訂單？請真的確定再按，請等待一下！！不要按F5及重新整理！')">送出訂單</button>
        {{ Form::close() }}
    @else
    <h4 class="text-danger">你不是導師！</h4>
    @endif

</div>
@endsection
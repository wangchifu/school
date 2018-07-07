@extends('layouts.master')

@section('page-title', '網站設定')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('colorpicker/css/htmleaf-demo.css') }}">
    <link href="{{ asset('colorpicker/dist/css/bootstrap-colorpicker.css') }}" rel="stylesheet">
    <style type="text/css">
        .colorpicker-component{margin-top: 10px;}
    </style>
<br><br><br>
<div class="container">
    <h1><i class="fas fa-desktop"></i> 網站設定</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">網站設定</li>
        </ol>
    </nav>
    {{ Form::open(['route' => 'setups.add_logo', 'method' => 'post','id'=>'logo', 'files' => true,'onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">網站小圖示</h3>
        <div class="card-body">
            <div class="form-group">
                <label for="file">圖檔( .ico .png )</label>
                {{ Form::file('logo', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('logo','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
            </div>
            @if(file_exists(storage_path('app/public/title_image/logo.ico')))
                <?php
                $logo = "title_image/logo.ico";
                $logo = str_replace('/','&',$logo);
                ?>
                <div style="float:left;padding: 10px;">
                    <img src="{{ url('img/'.$logo) }}" width="50">
                    <a href="{{ route('setups.del_img',['type'=>'title_image','filename'=>'logo.ico']) }}" id="del_logo" onclick="bbconfirm_Link('del_logo','確定移除小圖示嗎？')"><i class="fas fa-times-circle text-danger"></i></a>
                </div>
            @endif
        </div>
    </div>
    {{ Form::close() }}
    {{ Form::open(['route' => 'setups.add_img', 'method' => 'post','id'=>'img', 'files' => true,'onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">首頁標頭固定</h3>
        <div class="card-body">
            <div class="form-group">
                <label for="file">圖檔( 2000 x 400 )</label>
                {{ Form::file('file', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('img','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
            </div>
            @if(file_exists(storage_path('app/public/title_image/title_image.jpg')))
                <?php
                $title_image = "title_image/title_image.jpg";
                $title_image = str_replace('/','&',$title_image);
                ?>
                <div style="float:left;padding: 10px;">
                    <img src="{{ url('img/'.$title_image) }}" width="200">
                    <a href="{{ route('setups.del_img',['type'=>'title_image','filename'=>'title_image.jpg']) }}" id="del_title_image" onclick="bbconfirm_Link('del_title_image','確定移除固定標題圖片嗎？')"><i class="fas fa-times-circle text-danger"></i></a>
                </div>
            @endif
        </div>
    </div>
    {{ Form::close() }}
    {{ Form::open(['route' => 'setups.add_imgs', 'method' => 'post','id'=>'imgs', 'files' => true,'onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">輪播照片</h3>
        <div class="card-body">
            <div class="form-group">
                <label for="files[]">圖檔( 2000 x 400 )</label>
                {{ Form::file('files[]', ['class' => 'form-control','multiple'=>'multiple']) }}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('imgs','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
            </div>
            @if(!empty($files))
                @foreach($files as $k=>$v)
                    <?php
                    $file = "title_image/random/".$v;
                    $file = str_replace('/','&',$file);
                    ?>
                <div style="float:left;padding: 10px;">
                    <img src="{{ url('img/'.$file) }}" width="200">
                    <a href="{{ route('setups.del_img',['type'=>'random','filename'=>$v]) }}" id="del_image{{ $k }}" onclick="bbconfirm_Link('del_image{{ $k }}','確定移除輪播圖片嗎？')"><i class="fas fa-times-circle text-danger"></i></a>
                </div>
                @endforeach
            @endif
        </div>
    </div>
    {{ Form::close() }}
    {{ Form::open(['route' => ['setups.nav_color',$setup->id], 'method' => 'patch','id'=>'color','onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">網站顏色</h3>
        <div class="card-body">
            <div id="cp1" class="input-group mb-3 colorpicker-component">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">導覽列顏色</span>
                </div>
                <input type="text" class="form-control input-lg" value="#DD0F20" id="nav_color1" name="color[]">
                <div class="input-group-append">
                    <span class="input-group-addon btn btn-outline-secondary"><i></i></span>
                </div>
            </div>
            <div id="cp2" class="input-group mb-3 colorpicker-component">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon2">文字顏色</span>
                </div>
                <input type="text" class="form-control input-lg" value="#F18A31" id="nav_color2" name="color[]">
                <div class="input-group-append">
                    <span class="input-group-addon btn btn-outline-secondary"><i></i></span>
                </div>
            </div>
            <div id="cp3" class="input-group mb-3 colorpicker-component">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">連結文字顏色</span>
                </div>
                <input type="text" class="form-control input-lg" value="#F8EB48" id="nav_color3" name="color[]">
                <div class="input-group-append">
                    <span class="input-group-addon btn btn-outline-secondary"><i></i></span>
                </div>
            </div>
            <div id="cp4" class="input-group mb-3 colorpicker-component">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon4">連結文字移上時顏色</span>
                </div>
                <input type="text" class="form-control input-lg" value="#16813D" id="nav_color4" name="color[]">
                <div class="input-group-append">
                    <span class="input-group-addon btn btn-outline-secondary"><i></i></span>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('color','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
                @if(!empty($setup->nav_color))
                    <a href="{{ route('setups.nav_default') }}" class="btn btn-danger" id="default_color" onclick="bbconfirm_Link('default_color','確定還原嗎？')">
                        <i class="fas fa-trash"></i> 還原預設
                    </a>
                @endif
            </div>
        </div>
    </div>
    {{ Form::close() }}
    {{ Form::open(['route' => ['setups.update',$setup->id], 'method' => 'PATCH','id'=>'update','onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">啟用模組</h3>
        <div class="card-body">
            <?php

                foreach(config('app.modules') as $v){
                    if(strpos($modules, $v) !== false){
                        $check[$v] = "checked";
                    }else{
                        $check[$v] = "";
                    }
                }
            ?>
            <ul class="list-group">
                <li class="list-group-item">
                    <input type="checkbox" name="check['meetings']" id="meetings" {{ $check['meetings'] }}>
                    <label class="form-check-label" for="meetings">
                        <i class="fas fa-comments"></i> 會議文稿
                    </label>
                </li>
                <li class="list-group-item">
                    <input type="checkbox" name="check['school_plans']" id="school_plans" {{ $check['school_plans'] }}>
                    <label class="form-check-label" for="school_plans">
                        <i class="fas fa-book"></i> 校務計畫
                    </label>
                </li>
                <li class="list-group-item">
                    <input type="checkbox" name="check['tests']" id="tests" {{ $check['tests'] }}>
                    <label class="form-check-label" for="tests">
                        <i class="fas fa-check-square"></i> 問卷系統
                    </label>
                </li>
                <li class="list-group-item">
                    <input type="checkbox" name="check['classroom_orders']" id="classroom_orders" {{ $check['classroom_orders'] }}>
                    <label class="form-check-label" for="classroom_orders">
                        <i class="fas fa-list-ol"></i> 教室預約
                    </label>
                </li>
                <li class="list-group-item">
                    <input type="checkbox" name="check['fixes']" id="fixes" {{ $check['fixes'] }}>
                    <label class="form-check-label" for="fixes">
                        <i class="fas fa-wrench"></i> 報修系統
                    </label>
                </li>
                <li class="list-group-item">
                    <input type="checkbox" name="check['students']" id="students" {{ $check['students'] }}>
                    <label class="form-check-label" for="students">
                        <i class="fas fa-child"></i> 學生系統
                    </label>
                </li>
                <li class="list-group-item">
                    <input type="checkbox" name="check['lunches']" id="lunches" {{ $check['lunches'] }}>
                    <label class="form-check-label" for="lunches">
                        <i class="fas fa-utensils"></i> 午餐系統
                    </label>
                </li>
                <li class="list-group-item">
                    <input type="checkbox" name="check['sports']" id="sports" {{ $check['sports'] }}>
                    <label class="form-check-label" for="sports">
                        <i class="fas fa-football-ball"></i> 運動會報名系統
                    </label>
                </li>
                <li class="list-group-item">
                    <input type="checkbox" name="check['rewards']" id="rewards" {{ $check['rewards'] }}>
                    <label class="form-check-label" for="rewards">
                        <i class="fas fa-certificate"></i> 定期評量獎狀
                    </label>
                </li>
            </ul>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('update','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
    <script src="{{ asset('colorpicker/dist/js/bootstrap-colorpicker.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#mycp').colorpicker();
        });
        $(function () {
            $('#cp1,#cp2,#cp3,#cp4').colorpicker();
        });
    </script>
@endsection
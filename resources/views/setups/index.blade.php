@extends('layouts.master')

@section('page-title', '網站設定 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-desktop"></i> 網站設定</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">網站設定</li>
        </ol>
    </nav>
    {{ Form::open(['route' => 'setups.add_img', 'method' => 'post','id'=>'setup', 'files' => true,'onsubmit'=>'return false;']) }}
    <div class="card my-4">
        <h3 class="card-header">首頁標頭固定照片</h3>
        <div class="card-body">
            @include('layouts.alert')
            <div class="form-group">
                <label for="files[]">圖檔(  )</label>
                {{ Form::file('file', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                    <i class="fas fa-save"></i> 儲存設定
                </button>
                @if(file_exists(storage_path('app/public/title_image/title_image.jpg')))
                <a href="{{ route('setups.del_img') }}" class="btn btn-danger" id="del_title_image" onclick="bbconfirm_Link('del_title_image','確定移除嗎？')">
                    <i class="fas fa-trash"></i> 移除固定
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
@endsection
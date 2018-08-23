@extends('layouts.master')

@section('page-title', '個人設定')

@section('content')
<br><br><br>
<div class="container">
    <h1>個人設定</h1>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card my-4">
            <h3 class="card-header">變更個人密碼</h3>
            <div class="card-body">
                @if(env('LOGIN_LOCAL_OR_LDAP')=='local')
                    {{ Form::open(['route' => ['userData.resetPw',auth()->user()->id], 'method' => 'POST','id'=>'pw','onsubmit'=>'return false']) }}
                    <div class="form-group">
                        <label for="job_title">帳號：</label>
                        {{ auth()->user()->username }}
                    </div>
                    <div class="form-group">
                        <label for="old_password">舊密碼*</label>
                        <input id="old_password" name="old_password" type="password" class="form-control" placeholder="舊密碼">
                    </div>
                    <div class="form-group">
                            <label for="password">新密碼*</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="新密碼">
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">請再輸入一次密碼*</label>
                        <input id="password_confirm" name="password_confirm" type="password" class="form-control" placeholder="新密碼" onchange="check_pw();">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('pw','確定改密碼嗎？')">
                            <i class="fas fa-save"></i> 更改密碼
                        </button>
                    </div>
                    {{ Form::close() }}
                @elseif(env('DEFAULT_LOGIN_TYPE')=='ldap')
                    本系統已使用 LDAP 統一帳號密碼管理，請至 LDAP 伺服器變更密碼。<br><br>
                    <a href="http://{{ env('ADLDAP_CONTROLLERS') }}" target="_blank" class="btn btn-secondary btn-xs"><i class="fas fa-hand-point-up"></i> 立即前往 LDAP 伺服器</a>
                @endif
            </div>
        </div>
        </div>
        <div class="col-md-5">
            <div class="card my-4">
                <h3 class="card-header">變更個人資料</h3>
                <div class="card-body">
                    @include('layouts.alert')
                    {{ Form::open(['route' => ['userData.update',auth()->user()->id], 'method' => 'POST','id'=>'data','onsubmit'=>'return false']) }}
                    <div class="form-group">
                        <label for="job_title">職稱：</label>
                        {{ auth()->user()->job_title }}
                    </div>
                    <div class="form-group">
                        <label for="name"><strong>姓名*</strong></label>
                        {{ Form::text('name', auth()->user()->name, ['id' => 'name', 'class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label for="email">Email (公開)</label>
                        {{ Form::text('email', auth()->user()->email, ['id' => 'email', 'class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label for="website">網站 (公開)</label>
                        {{ Form::text('website', auth()->user()->website, ['id' => 'website', 'class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('data','確定改個人資料嗎？')">
                            <i class="fas fa-save"></i> 更改個人資料
                        </button>
                    </div>
                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function check_pw()
        {

            if(document.getElementById('password').value!=document.getElementById('password_confirm').value)
            {
                bbalert("兩次密碼不一樣！");
                document.getElementById('password').value = "";
                document.getElementById('password_confirm').value = "";
                document.getElementById('password').focus();
                return false;
            }
            else if(document.getElementById('password').value.length < 8){
                bbalert("密碼長度少於八碼");
                document.getElementById('password').value = "";
                document.getElementById('password_confirm').value = "";
                document.getElementById('password').focus();
                return false;
            }else{
                document.getElementById('theForm').submit();
            }

        }
    </script>
</div>
@endsection
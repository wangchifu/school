@extends('layouts.master')

@section('page-title', '校務行事曆-週次設定')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-calendar"></i> 校務行事曆-週次設定</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('calendars.index') }}">校務行事曆</a></li>
            <li class="breadcrumb-item active" aria-current="page">學期開學日設定</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4>新學期開學日設定</h4>
        </div>
        <div class="card-body">
            <form name="myform">
            <div class="form-group">
                <label for="open_date">
                    開學日
                </label>
                <input type="text" name="open_date" id="open_date" class="form-control" maxlength="10" placeholder="如：2018-08-30" required>
            </div>
            <div class="form-group">
                <a href="#" class="btn btn-success btn-sm" onclick="jump();">
                    <i class="fas fa-cog"></i> 開始設定
                </a>
            </div>
            </form>
            <script language='JavaScript'>

                function jump(){
                    if(document.myform.open_date.value!=''){
                        location="/calendar_weeks/create/" + document.myform.open_date.value;
                    }
                }
            </script>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>
                    已設定之學期
                </th>
            </tr>
            </thead>
            <tbody>
        @foreach($semesters as $v)
            <tr>
                <td>
                    {{ $v }}
                </td>
            </tr>
        @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
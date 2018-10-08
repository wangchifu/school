@extends('layouts.master_clean')

@section('page-title', '教學組-代課課表')

@section('content')
<br><br><br>
<?php
$ori_teacher = \App\User::where('id',$ori_sub->ori_teacher)->first();
$sub_teacher = \App\SubstituteTeacher::where('id',$ori_sub->sub_teacher)->first();
$sections = unserialize($ori_sub->sections);
?>
<div class="container">
    <h1>{{ $sub_teacher->teacher_name }}代課課表</h1>
    <h4>請假：{{ $ori_sub->abs_date }} {{ $ori_teacher->name }}-{{ $ori_sub->ps }}</h4>
    <div class="card">
        <div class="card-header">
            課表
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>
                        節次
                    </td>
                    <td>
                        {{ get_chinese_weekday($ori_sub->abs_date) }}
                    </td>
                </tr>
                @for($i=1;$i<8;$i++)
                    <tr>
                        <td>
                            {{ $i }}
                        </td>
                        <td>
                            @if($sections[$i]=="on")
                                代
                            @else

                            @endif
                        </td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>
</div>
@endsection
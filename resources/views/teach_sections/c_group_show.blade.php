@extends('layouts.master_clean')

@section('page-title', '教學組-代課課表')

@section('content')
<br><br><br>
<?php
$ori_teacher = \APP\User::where('id',$ori_sub->ori_teacher)->first();
$sub_teacher = \APP\User::where('id',$ori_sub->sub_teacher)->first();
$sections = unserialize($ori_sub->sections);
?>
<div class="container">
    <h1>{{ $sub_teacher->name }}代課課表</h1>
    <h4>{{ $ori_teacher->name }}-{{ $ori_sub->ps }}</h4>
    <div class="card">
        <div class="card-header">
            課表
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>

                    </td>
                    <td>
                        一
                    </td>
                    <td>
                        二
                    </td>
                    <td>
                        三
                    </td>
                    <td>
                        四
                    </td>
                    <td>
                        五
                    </td>
                </tr>
                @for($i=1;$i<8;$i++)
                    <tr>
                        <td>
                            {{ $i }}
                        </td>
                        @for($j=1;$j<6;$j++)
                        <td>
                            @if($sections[$j][$i]=="on")
                                代
                            @else

                            @endif
                        </td>
                        @endfor
                    </tr>
                @endfor
            </table>
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')

@section('page-title', '校務行事曆')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-calendar"></i> 校務行事曆</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">校務行事曆</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <table><tr>
            <td>
            <form name="myform">
            學期選單：
                <select name="semester" onchange="jump();">
                    <option>--請選擇--</option>
                    @foreach($semesters as $v)
                        <option value="{{ $v }}">{{ $v }}</option>
                    @endforeach
                </select>
            </form>
                <script language='JavaScript'>

                    function jump(){
                        if(document.myform.semester.options[document.myform.semester.selectedIndex].value!=''){
                            location="/calendars/index/" + document.myform.semester.options[document.myform.semester.selectedIndex].value;
                        }
                    }
                </script>
            </td>
            @if($has_week)
            @can('create',\App\Post::class)
                <td>
                <a href="{{ route('calendars.create',$this_semester) }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增{{ $semester }}學期行事</a>
                </td>
            @endcan
            @endif
            @auth
                @if(auth()->user()->admin)
                <td>
                    <a href="{{ route('calendar_weeks.index') }}" class="btn btn-info btn-sm"><i class="fas fa-cogs"></i> 學期管理</a>
                </td>
                @endif
            @endauth
                </tr></table>
        </div>
        <div class="card-body">
            <h3>{{ $semester }} 學期校務行事曆 <a href="{{ route('calendars.print',$semester) }}" class="btn btn-outline-dark btn-sm" target="_blank"><i class="fas fa-print"></i> 列印</a></h3>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="80">
                        週別
                    </th>
                    <th width="100">
                        起迄
                    </th>
                    @foreach(config('app.calendar_kind') as $v)
                    <th nowrap>
                        {{ $v }}
                    </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($calendar_weeks as $calendar_week)
                    <tr>
                        <td nowrap>
                            第 {{ $calendar_week->week }} 週
                        </td>
                        <td nowrap>
                            <small>{{ $calendar_week->start_end }}</small>
                        </td>
                        @foreach(config('app.calendar_kind') as $k =>$v)
                            <th>
                                @if(!empty($calendar_data[$calendar_week->id][$k]))
                                    <?php $i=1; ?>
                                    @foreach($calendar_data[$calendar_week->id][$k] as $k=>$v)
                                        <small class="text-primary">{{ $i }}.{{ $v['content'] }}</small>
                                        @auth
                                            @if($v['user_id'] == auth()->user()->id)
                                                <a href="{{ route('calendars.delete',$k) }}" class="text-danger" id="del{{ $k }}" onclick="bbconfirm_Link('del{{ $k }}','當真要刪？')"><i class="fas fa-minus-square"></i></a>
                                            @endif
                                        @endauth
                                        <br>
                                        <?php $i++; ?>
                                    @endforeach
                                @endif
                            </th>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
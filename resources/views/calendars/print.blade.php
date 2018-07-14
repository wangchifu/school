@extends('layouts.master_print')

@section('title',env('APP_SNAME')." ".$semester." 學期校務行事曆")

@section('content')
<h3 class="text-center">{{ env('APP_SNAME') }} {{ $semester }} 學期校務行事曆</h3>
<table class="table table-bordered">
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

@endsection

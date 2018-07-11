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
            學期：
            </td>
            @if($has_week)
            @can('create',\App\Post::class)
                <td>
                <a href="{{ route('calendars.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增事項</a>
                </td>
            @endcan
            @endif
            @auth
                @if(auth()->user()->admin)
                <td>
                    @if($has_week)
                        <a href="{{ route('calendars.week_delete') }}" class="btn btn-danger btn-sm" id="delete" onclick="bbconfirm_Link('delete','連同已寫上去的行事曆刪除喔！請確定！')"><i class="fas fa-trash"></i> 刪除本學期週次</a>
                    @else
                        <form action="{{ route('calendars.week_create') }}" method="post">
                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-cogs"></i> 設定週次</button>
                        <input type="text" name="open_date" maxlength="10" placeholder="開學日" required>(2018-08-30)
                    @csrf
                    </form>
                    @endif
                </td>
                @endif
            @endauth
                </tr></table>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="80">
                        週別
                    </th>
                    <th width="120">
                        起迄
                    </th>
                    @foreach(config('app.calendar_kind') as $v)
                    <th>
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
                            {{ $calendar_week->start_end }}
                        </td>
                        @foreach(config('app.calendar_kind') as $v)
                            <th>
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
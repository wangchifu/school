@extends('layouts.master')

@section('page-title', '會議列表 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-comments"></i> 會議列表</h1>
    @can('create',\App\Meeting::class)
        <a href="{{ route('meetings.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增會議</a>
    @endcan
    <br><br>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>會議日期</th>
            <th>會議名稱</th>
            <th>報告人次</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($meetings as $meeting)
            <tr>
                <td>{{ $meeting->open_date }} {{ get_chinese_weekday($meeting->open_date) }}</td>
                <td><a href="{{ route('meetings.show',$meeting->id) }}">{{ $meeting->name }}</a></td>
                <td>{{ $meeting->reports->count() }}</td>
                <td>
                    @can('update',$meeting)
                        <a href="{{ route('meetings.edit',$meeting->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 修改</a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $meeting->id }}','當真要刪除？')"><i class="fas fa-trash"></i> 刪除</a>
                        {{ Form::open(['route' => ['meetings.destroy',$meeting->id], 'method' => 'DELETE','id'=>'delete'.$meeting->id,'onsubmit'=>'return false;']) }}
                        {{ Form::close() }}
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $meetings->links() }}
</div>
@endsection
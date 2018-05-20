@extends('layouts.master')

@section('page-title', '會議報告 | 和東國小')

@section('content')
    <br><br>
    <div class="container">

        <div class="row">
            <div class="col-lg-9">
                <h1 class="mt-4"><i class="fas fa-comments"></i> {{ $meeting->open_date }} {{ get_chinese_weekday($meeting->open_date) }} {{ $meeting->name }}<a href="#" class="btn btn-primary"><i class="fas fa-download"></i> 報告內容下載</a></h1>
                <a href="{{ route('meetings.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
                @can('create',\App\Meeting::class)
                    @if($has_report=="0" and $die_line =="0")
                        <a href="{{ route('meetings_reports.create',$meeting->id) }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增報告</a>
                    @endif
                @endcan
                <hr>
                <?php $i=1; ?>
                @foreach($reports as $report)
                    <?php
                    //有無附件
                    $files = get_files(storage_path('app/public/reports/'.$report->id));
                    ?>
                    <div class="card my-4">
                        <h3 class="card-header">
                            {{ $i }}.{{ $report->job_title }}
                            @if($has_report == "1" and $report->user_id = auth()->user()->id and $die_line =="0")
                                <a href="{{ route('meetings_reports.edit',$report->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 修改</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $report->id }}','當真要刪除？')"><i class="fas fa-trash"></i> 刪除</a>
                                {{ Form::open(['route' => ['meetings_reports.destroy',$report->id], 'method' => 'DELETE','id'=>'delete'.$report->id,'onsubmit'=>'return false;']) }}
                                {{ Form::close() }}
                            @endif
                        </h3>
                        <div class="card-body">
                            <p style="font-size: 1.2rem;">
                                {!! $report->content !!}
                            </p>
                        </div>
                        @if(!empty($files))
                            <div class="card-footer">
                                附件：
                                @foreach($files as $k=>$v)
                                    <?php
                                    $file = "reports/".$report->id."/".$v;
                                    $file = str_replace('/','&',$file);
                                    ?>
                                    <a href="{{ url('file/'.$file) }}" class="btn btn-primary btn-sm"><i class="fas fa-download"></i> {{ $v }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <?php $i++; ?>
                @endforeach
                <hr>


            </div>

            <div class="col-md-3">

                <div class="card my-4">
                    <h5 class="card-header">相關資訊</h5>
                    <div class="card-body">
                        @if($die_line == 1)
                        <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-lock"></i> 已鎖定</a>
                        @endif
                        <p class="lead">
                            報告人次：{{ $meeting->reports->count() }}
                        </p>
                        <p class="lead">
                        觀看人次：
                        </p>
                        <p class="lead">
                        已觀看名單：
                        </p>
                    </div>
                </div>

            </div>

        </div>


    </div>
@endsection
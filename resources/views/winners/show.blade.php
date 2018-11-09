@extends('layouts.master')

@section('page-title', '填報獎狀名單')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="far fa-check-square"></i> 填報獎狀名單</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">獎狀填報列表</a></li>
            <li class="breadcrumb-item active" aria-current="page">得獎名單</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card my-4">
                <h3 class="card-header">{{ $reward->name }} 得獎名單 <a href="{{ route('winners.print',$reward->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-print"></i> 列印</a></h3>
                <div class="card-body">
                    @foreach($has_classes as $k1=>$v1)
                        <h4>{{ back_cht_year_class($k1) }}</h4>
                        @foreach($lists as $k2=>$v2)
                            @if(isset($winners[$k1][$k2]['name']))
                            <h5>{{ $v2['title'] }}：{{ $winners[$k1][$k2]['name'] }}</h5>
                            @endif
                        @endforeach
                        @if(isset($winners[$k1][$k2]['teacher']))
                        <small class="text-primary">({{ $winners[$k1][$k2]['teacher'] }} 填報)</small>
                        @endif
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
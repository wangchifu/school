@extends('layouts.master')

@section('page-title', '報修系統')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-wrench"></i> 報修系統</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">報修列表</li>
        </ol>
    </nav>
    <a href="{{ route('fixes.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增報修項目</a>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th width="120">處理狀況</th>
            <th width="150">申報日期</th>
            <th width="120">申報人</th>
            <th>標題</th>
            <th width="120">處理日期</th>
        </tr>
        </thead>
        <tbody>
        @foreach($fixes as $fix)
            <tr>
              <td>
                <?php
                  $situation=['1'=>'處理完畢','2'=>'處理中','3'=>'申報中'];
                  $icon = [
                      '1'=>'<i class="fas fa-check-square text-success"></i>',
                      '2'=>'<i class="fas fa-exclamation-triangle text-warning"></i>',
                      '3'=>'<i class="fas fa-phone-square text-danger"></i>'
                  ];
                  ?>
                  {!! $icon[$fix->situation] !!} <a href="{{ route('fixes.search',$fix->situation) }}">{{ $situation[$fix->situation] }}</a>
              </td>
              <td>
                  {{ substr($fix->created_at,0,10) }}
              </td>
              <td>
                  {{ $fix->user->name }}
              </td>
              <td>
                  <a href="{{ route('fixes.show',$fix->id) }}">{{ $fix->title }}</a>
              </td>
              <td>
                  @if($fix->situation < 3)
                  {{ substr($fix->updated_at,0,10) }}
                  @endif
              </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    {{ $fixes->links() }}
</div>
@endsection
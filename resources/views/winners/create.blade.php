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
            <li class="breadcrumb-item active" aria-current="page">填報獎狀名單</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.alert')
            <div class="card my-4">
                <h3 class="card-header">{{ $reward->name }} 得獎名單</h3>
                <div class="card-body">
                    <p>填報人：{{ auth()->user()->name }}</p>
                    @foreach($list_data as $k1 => $v1)
                        @foreach($v1 as $k2=>$v2)
                            <?php
                            $has_do = \App\Winner::where('user_id',auth()->user()->id)
                                ->where('reward_id',$reward->id)
                                ->where('reward_list_id',$k2)
                                ->first();
                            ?>
                            @if(empty($has_do))
                                <div class="form-group">
                                    <label for="name">
                                        <strong class="text-danger">{{ $v2['title'] }}*</strong>
                                    </label>
                                    {{ Form::open(['route' => 'winners.store', 'method' => 'POST']) }}
                                    <table>
                                        <tr>
                                            <td width="120">
                                                <select name="year_class" class="form-control" onChange="location.href='{{ url('winners/'.$reward->id.'/create') }}'+'/'+this.value" required>
                                                    <option>請選班級</option>
                                                    @foreach($year_classes as $k=>$v)
                                                        <?php $selected = ($select_year_class==$k)?"selected":null; ?>
                                                        <option value="{{ $k }}" {{ $selected }}>{{ $v }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="student_id" class="form-control" required>
                                                    <option>請選學生</option>
                                                    @foreach($students as $k=>$v)
                                                        <option value="{{ $k }}">{{ $v['num'] }}_{{ $v['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-primary" onclick="return confirm('確定送出？')">
                                                    <i class="fas fa-plane"></i> 送出
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="reward_id" value="{{ $reward->id }}">
                                    <input type="hidden" name="reward_list_id" value="{{ $k2 }}">
                                    {{ Form::close() }}
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="name">
                                        <strong class="text-danger">{{ $v2['title'] }}*</strong>
                                    </label>
                                    <table>
                                        <tr>
                                            <td width="120">
                                                {{ $has_do->year_class }}
                                            </td>
                                            <td>
                                                {{ $has_do->name }}
                                            </td>
                                            <td>
                                                <a href="{{ route('winners.destroy',$has_do->id) }}" onclick="return confirm('確定刪除？')"><i class="fas fa-times-circle text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
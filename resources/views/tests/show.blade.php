@extends('layouts.master')

@section('page-title', '問卷結果 | 和東國小')

@section('content')
<br><br><br>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover();

        $('body').on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
    })
</script>
<div class="container">
    <h1><i class="far fa-check-square"></i> [ {{ $test->name }} ] 問卷結果</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tests.index') }}">問卷系統</a></li>
            <li class="breadcrumb-item active" aria-current="page">問卷結果</li>
        </ol>
    </nav>
    <a href="{{ route('tests.download',['test'=>$test->id,'type'=>'csv']) }}" class="btn btn-primary btn-xs"><i class="fas fa-download"></i> 下載結果 [CSV] </a>
    <a href="{{ route('tests.download',['test'=>$test->id,'type'=>'xls']) }}" class="btn btn-primary btn-xs"><i class="fas fa-download"></i> 下載結果 [EXCEL] </a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th nowrap width="60"> -- </th>
            <?php $i =1; ?>
            @foreach($question as $k1=>$v1)
                <th>
                    <a href="#" data-container="body" data-toggle="popover" data-placement="bottom" data-content="{{ $v1['title'] }}">
                        題{{ $i }}
                    </a>
                </th>
                <?php $i++ ?>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($user as $k2=>$v2)
        <tr>
            <td nowrap>
                <?php $user = explode('-',$v2); ?>
                <a href="#" data-container="body" data-toggle="popover" data-placement="bottom" data-content="{{ $user[0]}}">
                    {{ $user[1] }}
                </a>
            </td>
            @foreach($question as $k3=>$v3)
                <td>
                    {!! nl2br($answer[$k2][$v3['id']]) !!}
                </td>
            @endforeach
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
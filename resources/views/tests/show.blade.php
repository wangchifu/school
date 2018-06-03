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
    <table class="table table-striped">
        <thead>
        <tr>
            <th nowrap width="60"> -- </th>
            <?php $i =1; ?>
            @foreach($question as $k1=>$v1)
                <th>
                    <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="bottom" data-content="{{ $v1['title'] }}">
                        第 {{ $i }} 題
                    </button>
                </th>
                <?php $i++ ?>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($user as $k2=>$v2)
        <tr>
            <td>
                {{ $v2 }}
            </td>
            @foreach($question as $k3=>$v3)
                <td>
                    {{ $answer[$k2][$v3['id']] }}
                </td>
            @endforeach
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
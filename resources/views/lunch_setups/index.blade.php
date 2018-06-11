@extends('layouts.master')

@section('page-title', '午餐設定 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 午餐設定</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item active" aria-current="page">午餐設定</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['setup'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    @if($admin)
    <a href="{{ route('lunch_setups.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增學期設定</a>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>學期</th>
            <th>教職員收費</th>
            <th>學生收費</th>
            <th>學生退費</th>
            <th>部分補助金額</th>
            <th>全額補助金額</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lunch_setups as $lunch_setup)
            <tr>
                <td>
                    {{ $lunch_setup->semester }}
                </td>
                <td>
                    {{ $lunch_setup->tea_money }}
                </td>
                <td>
                    {{ $lunch_setup->stud_money }}
                </td>
                <td>
                    {{ $lunch_setup->stud_back_money }}
                </td>
                <td>
                    {{ $lunch_setup->support_part_money }}
                </td>
                <td>
                    {{ $lunch_setup->support_all_money }}
                </td>
                <td>
                    <a href="{{ route('$lunch_setups.show',$lunch_setup->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> 詳細資料</a>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    {{ $lunch_setups->links() }}
    @else
        <h1 class="text-danger">你不是管理者</h1>
    @endif
</div>
@endsection
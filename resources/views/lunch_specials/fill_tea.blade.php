@extends('layouts.master')

@section('page-title', '教師補訂餐')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 教職補訂餐</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">特殊處理</li>
            <li class="breadcrumb-item active" aria-current="page">教職補訂餐</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['special'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    <div class="card">
        <div class="card-header">
            <h2>教職補訂餐步驟</h2>
        </div>
        <div class="card-body">
            1.至「午餐設定」修改該學期為「打勾為隨時可訂」。<br>
            2.請該師立刻訂餐！<br>
            3.將步驟1 再次勾掉，不讓教師隨時訂餐！
        </div>
    </div>
</div>
@endsection

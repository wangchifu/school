@extends('layouts.master')

@section('page-title', '顯示內容')

@section('content')
<div class="container">
    <br><br>
    <div class="card my-4">
        <h3 class="card-header"><a href="#" onclick="history.back()"><i class="fas fa-backward"></i></a> {{ $content->title }}</h3>
        <div class="card-body">
        {!! $content->content !!}
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')

@section('page-title', '網聯教師')

@section('content')
<div class="container">
    <br><br>
    <div class="card my-4">
        <h3 class="card-header"><a href="#" onclick="history.back()"><i class="fas fa-backward"></i></a> 網聯教師</h3>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>職稱</th>
                    <th>姓名</th>
                    <th>網站</th>
                    <th>郵件</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->job_title }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if($user->website)
                                <a href="{{ $user->website }}" target="_blank"><i class="fas fa-globe"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($user->email)
                                {{ $user->email }}
                            @endif
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
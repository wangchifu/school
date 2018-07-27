@extends('layouts.master')

@section('page-title', '本校公告')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-bullhorn"></i> 本校公告</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">公告列表</li>
        </ol>
    </nav>
    @can('create',\App\Post::class)
        <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增公告</a>
    @endcan
    <div align="right">
        <form action="{{ route('posts.search') }}" method="post" class="search-form" id="search_form">
            {{ csrf_field() }}
            <table>
            <tr>
                <td>
                    <input type="text" name="search" id="search" placeholder="搜尋公告">
                </td>
                <td>
                    <input type="radio" name="type" id="title" value="title" class="search-form"> <label for="title">標題</label>　
                    <input type="radio" name="type" id="content" value="content" checked class="search-form"> <label for="content">內文</label>

                </td>
                <td>
                    <button><i class="fas fa-search"></i></button>
                </td>
            </tr>
        </table>
        </form>
    </div>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>日期</th>
            <th>
                標題
            </th>
            <th>發佈者</th>
            <th>點閱</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if($_SERVER['REMOTE_ADDR'] == env('SCHOOL_IP')){
                $client_in = "1";
            }else{
                $client_in = "0";
            }
        ?>
        @foreach($posts as $post)
            <tr>
                <td width="120">
                    {{ substr($post->created_at,0,10) }}
                </td>
                <td>
                    <?php
                    $title = str_limit($post->title,80);
                    //有無附件
                    $files = get_files(storage_path('app/public/posts/'.$post->id));
                    ?>
                    @if($post->insite)
                        @if($client_in=="1" or auth()->check())
                                <span class="text-danger">[校內]</span> <a href="{{ route('posts.show',$post->id) }}">{{ $title }}</a>
                        @else
                                <p class='btn btn-danger btn-sm'>校內文件</p>
                        @endif
                    @else
                            <a href="{{ route('posts.show',$post->id) }}">{{ $title }}</a>
                    @endif
                    @if(!empty($files))
                            <span class="text-info"><i class="fas fa-file"></i> [附件]</span>
                    @endif
                </td>
                <td width="100">
                    <a href="{{ route('posts.job_title',$post->job_title) }}">{{ $post->job_title }}</a>
                </td>
                <td width="80">
                    {{ $post->views }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $posts->links() }}
</div>
@endsection
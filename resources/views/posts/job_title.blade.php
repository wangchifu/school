@extends('layouts.master')

@section('page-title', '本校公告 | 和東國小')

@section('content')
<style>
    .search-form .form-group {
        float: right !important;
        transition: all 0.35s, border-radius 0s;
        width: 32px;
        height: 32px;
        background-color: #fff;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        border-radius: 25px;
        border: 1px solid #ccc;
    }
    .search-form .form-group input.form-control {
        padding-right: 20px;
        border: 0 none;
        background: transparent;
        box-shadow: none;
        display:block;
    }
    .search-form .form-group input.form-control::-webkit-input-placeholder {
        display: none;
    }
    .search-form .form-group input.form-control:-moz-placeholder {
        /* Firefox 18- */
        display: none;
    }
    .search-form .form-group input.form-control::-moz-placeholder {
        /* Firefox 19+ */
        display: none;
    }
    .search-form .form-group input.form-control:-ms-input-placeholder {
        display: none;
    }
    .search-form .form-group:hover,
    .search-form .form-group.hover {
        width: 100%;
        border-radius: 4px 25px 25px 4px;
    }
    .search-form .form-group span.form-control-feedback {
        position: absolute;
        top: 0px;
        right: 13px;
        z-index: 2;
        display: block;
        width: 34px;
        height: 34px;
        line-height: 34px;
        text-align: center;
        color: #3596e0;
        left: initial;
        font-size: 14px;
    }
</style>
<br><br><br>
<div class="container">
    <h1>{{ $job_title }}公告</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 返回</a>
    <div class="row">
        <div class="col-md-4 col-md-offset-3">
            <form action="{{ route('posts.search') }}" method="post" class="search-form" id="search_form">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Search</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="搜尋公告內文，按Enter">
                    <span class="fas fa-search form-control-feedback"></span>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>日期</th>
            <th>公告標題</th>
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
                                <a href="{{ route('posts.show',$post->id) }}">{{ $title }}</a>
                        @else
                                <p class='btn btn-danger btn-sm'>校內文件</p>
                        @endif
                    @else
                            <a href="{{ route('posts.show',$post->id) }}" target="_blank">{{ $title }}</a>
                    @endif
                    @if(!empty($files))
                            <span class="text-info"><i class="fas fa-file"></i> [附件]</span>
                    @endif
                </td>
                <td width="100">
                    {{ $post->job_title }}
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
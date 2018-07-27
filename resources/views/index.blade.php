@extends('layouts.master')

@section('page-title', '首頁')

@section('content')
    <?php
    $title_path = "title_image/";
    //有無附件
    $path = "title_image/random/";
    $banners = get_files(storage_path("app/public/".$path));
    $n = count($banners);
    ?>
    <br>
    <br>
    @if($setup->title_image == null)
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
            <ol class="carousel-indicators">
                @for($i=0;$i<$n;$i++)
                    <?php $active = ($i==0)?"active":""; ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" class="{{ $active }}"></li>
                @endfor
            </ol>
            <div class="carousel-inner">
                <?php $i=0; ?>
                @if(!empty($banners))
                    @foreach($banners as $k=>$v)
                        <?php
                        $file = $path.$v;
                        $file = str_replace('/','&',$file);
                        $active = ($i==0)?"active":"";
                        $title1 = explode(".",$v);
                        $title = explode("-",$title1[0]);
                        ?>
                        <div class="carousel-item {{ $active }}">
                            <img class="d-block w-100" src="{{ url('img/'.$file) }}">
                            <div class="carousel-caption d-none d-md-block" style="background-color: rgba(255,255,255,0.2);padding: 5px;border-radius:10px;">
                                <h1 class="text-left"><i class="far fa-keyboard"></i> {{ $title[1] }}</h1>
                            </div>
                        </div>
                        <?php $i++; ?>
                    @endforeach
                @endif
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    @else
        <?php
        $file = $title_path."title_image.jpg";
        $file = str_replace('/','&',$file);
        ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
            <ol class="carousel-indicators">

                <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>

            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ url('img/'.$file) }}">
                    <div class="carousel-caption d-none d-md-block" style="background-color: rgba(255,255,255,0.2);padding: 5px">
                        <h1 class="text-left"><i class="far fa-keyboard"></i> {{ $setup->title_image }}</h1>
                    </div>
                </div>
            </div>
        </div>
    @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="contents/1"><i class="fas fa-align-justify"></i> 認識和東</a></li>
                <li class="breadcrumb-item"><a href="{{ route('teachers.link') }}"><i class="fas fa-align-justify"></i> 網聯教師</a></li>
                <li class="breadcrumb-item"><a href="contents/2"><i class="fas fa-align-justify"></i> 活動剪影</a></li>
                <li class="breadcrumb-item"><a href="contents/3"><i class="fas fa-align-justify"></i> 教學網站</a></li>
                <li class="breadcrumb-item"><a href="contents/6"><i class="fas fa-align-justify"></i> 教學資源</a></li>
                <li class="breadcrumb-item"><a href="contents/4"><i class="fas fa-align-justify"></i> 宣導網站</a></li>
                <li class="breadcrumb-item"><a href="contents/7"><i class="fas fa-align-justify"></i> 自我進修</a></li>
                <li class="breadcrumb-item"><a href="contents/5"><i class="fas fa-align-justify"></i> 聯絡和東</a></li>
            </ol>
        </nav>
<div class="container">
    <table class="w-100">
        <tr>
            <td>
                <h1>最新公告</h1>
            </td>
            <td align="right">
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
            </td>
        </tr>
    </table>
    @can('create',\App\Post::class)
        <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> 新增公告</a>
    @endcan
    <div id="post">
        <table class="table table-striped">
            <thead class="thead-light">
            <tr>
                <th nowrap>
                    編號
                </th>
                <th nowrap>
                    日期
                </th>
                <th width="150" nowrap>
                    標題圖片
                </th>
                <th nowrap>
                    標題
                </th>
                <th nowrap>發佈者</th>
                <th nowrap>點閱</th>
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

                <?php

                if(empty($post->title_image)){
                    $img = asset('img/title_image/'.$post->job_title.'.png');
                }else{
                    $path = "posts/".$post->id."/title_image.png";
                    $path = str_replace('/','&',$path);
                    $img = url('img/'.$path);
                }
                //$title = str_limit($post->title,54);
                //$content = str_limit($post->content,200);
                ?>

                <tr>
                    <td>
                        {{ $post->id }}
                    </td>
                    <td width="120">
                        {{ substr($post->created_at,0,10) }}
                    </td>
                    <td>
                        <img src="{{ $img }}" class="img-fluid rounded">
                    </td>
                    <td>
                        <?php
                        $title = str_limit($post->title,100);
                        //有無附件
                        $files = get_files(storage_path('app/public/posts/'.$post->id));
                        ?>
                        @if($post->insite)
                            @if($client_in=="1" or auth()->check())
                                <p style="font-size: 1.2rem;">
                                    <span class="text-danger">[校內]</span> <a href="{{ route('posts.show',$post->id) }}">{{ $title }}</a>
                                </p>
                            @else
                                <p class='btn btn-danger btn-sm'>校內文件</p>
                            @endif
                        @else
                            <p style="font-size: 1.2rem;">
                                <a href="{{ route('posts.show',$post->id) }}">{{ $title }}</a>
                            </p>
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
</div>
@endsection
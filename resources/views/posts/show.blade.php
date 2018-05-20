@extends('layouts.master')

@section('page-title', '新增公告 | 和東國小')

@section('content')
<br><br>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-9">

            <!-- Title -->
            <?php
            if($_SERVER['REMOTE_ADDR'] == env('SCHOOL_IP')){
                $client_in = "1";
            }else{
                $client_in = "0";
            }
            if($post->insite){
                if($client_in=="1" or auth()->check()){
                    $can_see = 1;
                }else{
                    $can_see = 0;
                }
            }else{
                $can_see = 1;
            };
            ?>
            @if($can_see)
                <h1 class="mt-4">{{ $post->title }}</h1>
            @else
                <h1 class="mt-4 text-danger">校內文件</h1>
            @endif

            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> 回列表</a>
            @if($last_id)
                <a href="{{ route('posts.show',$last_id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-alt-circle-left"></i> 上一則公告</a>
            @endif
            @if($next_id)
                <a href="{{ route('posts.show',$next_id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-alt-circle-right"></i> 下一則公告</a>
            @endif

            <br><br>
            <p class="lead">
                張貼
                <a href="{{ route('posts.job_title',$post->job_title) }}">{{ $post->job_title }}</a>　　　
                @can('update',$post)
                <a href="{{ route('posts.edit',$post->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 修改</a>
                <a href="#" class="btn btn-danger btn-sm" onclick="bbconfirm_Form('delete{{ $post->id }}','當真要刪除？')"><i class="fas fa-trash"></i> 刪除</a>
                {{ Form::open(['route' => ['posts.destroy',$post->id], 'method' => 'DELETE','id'=>'delete'.$post->id,'onsubmit'=>'return false;']) }}
                {{ Form::close() }}
                @endcan
            </p>

            <hr>

            <!-- Date/Time -->
            <p>
                張貼日期： {{ $post->created_at }}　　　
                點閱：{{ $post->views }}
            </p>

            <hr>

            <!-- Preview Image -->
            @if(!empty($post->title_image) and $can_see)
                <?php
                $path = "posts/".$post->id."/title_image.png";
                $path = str_replace('/','&',$path);
                $img = url('img/'.$path);
                ?>
                <img class="img-fluid rounded" src="{{ $img }}" alt="標題圖片">

                <hr>
            @endif

            <!-- Post Content -->
            <p style="font-size: 1.2rem;">
                @if($can_see)
                    <?php $content = str_replace(chr(13) . chr(10), '<br>', $post->content);?>
                    {!! $content !!}
                @else
                <p class="text-danger">[校內文件]請在校內或是登入後觀看！</p>
                @endif

            </p>

            <hr>
            @if(!empty($files) and $can_see)
            <div class="card my-4">
                <h5 class="card-header">附件下載</h5>
                <div class="card-body">
                @foreach($files as $k=>$v)
                        <?php
                            $file = "posts/".$post->id."/".$v;
                            $file = str_replace('/','&',$file);
                        ?>
                        <a href="{{ url('file/'.$file) }}" class="btn btn-primary btn-sm"><i class="fas fa-download"></i> {{ $v }}</a>
                @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-3">

            <div class="card my-4">
                <h5 class="card-header">熱門公告</h5>
                <div class="card-body">
                @foreach($hot_posts as $hot_post)
                        <li><a href="{{ route('posts.show',$hot_post->id) }}">{{ $hot_post->title }}</a></li>
                @endforeach
                </div>
            </div>

        </div>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

@endsection
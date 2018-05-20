@extends('layouts.master')

@section('page-title', '首頁 | 和東國小')

@section('content')
<header class="bg-primary text-white" style="background:#fff url('https://www.taiwan.net.tw/resources/images/Attractions/0001095.jpg');background-size: 100% 100%;">
    <div class="container text-center">
        <h1>歡迎光臨 彰化縣和東國小全球資訊網</h1>
        <p class="lead">Welcome To ChangHua HoDong Elementary School World Wide Web</p>
    </div>
</header>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav_menu">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link js-scroll-trigger" href="#post">
                    <i class="fas fa-align-justify"></i> 最新公告
                </a>
                <a class="nav-item nav-link js-scroll-trigger" href="#about">
                    <i class="fas fa-align-justify"></i> 認識和東
                </a>
                <a class="nav-item nav-link js-scroll-trigger" href="#people">
                    <i class="fas fa-align-justify"></i> 教職員工
                </a>
                <a class="nav-item nav-link js-scroll-trigger" href="#active">
                    <i class="fas fa-align-justify"></i> 活動剪影
                </a>
                <a class="nav-item nav-link js-scroll-trigger" href="#teach">
                    <i class="fas fa-align-justify"></i> 教學網站
                </a>
                <a class="nav-item nav-link js-scroll-trigger" href="#resource">
                    <i class="fas fa-align-justify"></i> 教學資源
                </a>
                <a class="nav-item nav-link js-scroll-trigger" href="#tell">
                    <i class="fas fa-align-justify"></i> 宣導網站
                </a>
                <a class="nav-item nav-link js-scroll-trigger" href="#contact">
                    <i class="fas fa-align-justify"></i> 聯絡和東
                </a>
            </div>
        </div>
    </nav>
    <div id="post">
        <h2>最新公告</h2>
        @foreach($posts as $post)
            <?php
            if($_SERVER['REMOTE_ADDR'] == env('SCHOOL_IP')){
                $client_in = "1";
            }else{
                $client_in = "0";
            }

            if(empty($post->title_image)){
                $img = asset('img/title_image/'.$post->job_title.'.png');
            }else{
                $path = "posts/".$post->id."/title_image.png";
                $path = str_replace('/','&',$path);
                $img = url('img/'.$path);
            }
            $title = str_limit($post->title,54);
            $content = str_limit($post->content,200);
            ?>
        <div class="row">
            <div class="col-md-3">
                <img class="img-fluid rounded mb-3 mb-md-0" src="{{ $img }}" alt="標題圖片">
            </div>
            <div class="col-md-9">
                @if($post->insite)
                    @if($client_in=="1" or auth()->check())
                        <h3>{{ $title }}</h3>
                        <p>
                            {{ $content }}
                            <br>
                            <a class="btn btn-primary" href="{{ route('posts.show',$post->id) }}">詳細內容</a>
                        </p>
                        <a class="btn btn-primary btn-sm" href="{{ route('posts.show',$post->id) }}">詳細內容</a>
                    @else
                        <p class='btn btn-danger'>校內文件</p>
                    @endif
                @else
                    <h3>{{ $title }}</h3>
                    <p>
                        {{ $content }}
                        <br>
                        <a class="btn btn-primary" href="{{ route('posts.show',$post->id) }}">詳細內容</a>
                    </p>
                @endif
            </div>
        </div>
        <!-- /.row -->

        <hr>
        @endforeach
        {{ $posts->links() }}
    </div>

    <br><br><br><br>
    <div id="about" class="bg-light">
        <h2>認識和東</h2>
        @if(!empty($open_contents['認識和東']))
        {!! $open_contents['認識和東'] !!}
        @endif
    </div>

    <br><br><br><br>
    <div id="people">
        <h2>教職員工</h2>
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

    <br><br><br><br>
    <div id="active" class="bg-light">
        <h2>活動剪影</h2>
        @if(!empty($open_contents['活動剪影']))
            {!! $open_contents['活動剪影'] !!}
        @endif
    </div>

    <br><br><br><br>
    <div id="teach" class="bg-light">
        <h2>教學網站</h2>
        @if(!empty($open_contents['教學網站']))
            {!! $open_contents['教學網站'] !!}
        @endif
    </div>

    <br><br><br><br>
    <div id="resource">
        <h2>教學資源</h2>
        @if(!empty($open_contents['教學資源']))
            {!! $open_contents['教學資源'] !!}
        @endif
    </div>

    <br><br><br><br>
    <div id="tell" class="bg-light">
        <h2>宣導網站</h2>
        @if(!empty($open_contents['宣導網站']))
            {!! $open_contents['宣導網站'] !!}
        @endif
    </div>

    <br><br><br><br>
    <div id="contact">
        <h2>聯絡和東</h2>
        @if(!empty($open_contents['聯絡和東']))
            {!! $open_contents['聯絡和東'] !!}
        @endif
    </div>


</div>
@endsection
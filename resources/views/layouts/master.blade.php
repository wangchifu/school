<!DOCTYPE html>
<html lang="zh-TW">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('page-title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('theme/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('theme/css/scrolling-nav.css') }}" rel="stylesheet">

    <!-- icons -->
    <link href="{{ asset('fontawesome/css/fontawesome-all.css') }}" rel="stylesheet">

    <script src="{{ asset('theme/vendor/jquery/jquery.min.js') }}"></script>

  </head>

  <body id="page-top">
  <style>
    #gotop {
      position:fixed;
      z-index:90;
      right:30px;
      bottom:31px;
      display:none;
      width:50px;
      height:50px;
      color:#000000;
      background:#f8f8f8;
      line-height:50px;
      border-radius:50%;
      transition:all 0.5s;
      text-align: center;
      box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    }
    #gotop :hover{
      background:#0099CC;
    }
  </style>

  <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a href="#page-top">
          <img src="{{ asset('img/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
        </a>
        <a class="navbar-brand js-scroll-trigger" href="{{  route('index') }}">
          {{ env('APP_NAME') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('posts.index') }}">
                <i class="fas fa-bullhorn"></i> 本校公告
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('open_files.index') }}">
                <i class="fas fa-box-open"></i> 公開文件
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-inbox"></i> 校內行政
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('meetings.index') }}"><i class="fas fa-comments"></i> 會議文稿</a>
                <a class="dropdown-item" href="{{ route('school_plans.index') }}"><i class="fas fa-book"></i> 校務計畫</a>
                <a class="dropdown-item" href="#"><i class="far fa-check-square"></i> 問卷系統x</a>
                <a class="dropdown-item" href="#"><i class="fas fa-list-ol"></i> 教室預約x</a>
                <a class="dropdown-item" href="{{ route('fixes.index') }}"><i class="fas fa-wrench"></i> 報修系統*</a>
                <a class="dropdown-item" href="{{ route('students.index') }}"><i class="fas fa-child"></i> 學生系統*</a>
                <a class="dropdown-item" href="#"><i class="fas fa-utensils"></i> 午餐系統x*</a>
                <a class="dropdown-item" href="#}"><i class="fas fa-football-ball"></i> 運動會報名系統x*</a>
              </div>
            </li>
              <?php
              $links = \App\Link::orderBy('order_by')->get();
              $in_link = [];
              $out_link = [];
              if(!empty($links)){
              foreach($links as $link){
                  if($link->type == "1"){
                      $in_link[$link->name] = $link->url;
                  }
                  if($link->type == "2"){
                      $out_link[$link->name] = $link->url;
                  }
              }
              }
              ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fab fa-linkedin"></i> 校內網站
              </a>
              @foreach($in_link as $k=>$v)
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ $v }}" target="_blank">{{ $k }}</a>
              </div>
              @endforeach
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-external-link-square-alt"></i> 校外系統
              </a>
              @foreach($out_link as $k=>$v)
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="{{ $v }}" target="_blank">{{ $k }}</a>
                </div>
              @endforeach
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            @if (auth()->check())
              @if(auth()->user()->admin)
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cogs"></i> 系統設定
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('users.index') }}"><i class="fas fa-user"></i> 帳號管理</a>
                    <a class="dropdown-item" href="{{ route('groups.index') }}"><i class="fas fa-users"></i> 群組管理</a>
                    <a class="dropdown-item" href="{{ route('contents.index') }}"><i class="fas fa-file-alt"></i> 內容管理</a>
                    <a class="dropdown-item" href="{{ route('links.index') }}"><i class="fas fa-link"></i> 連結管理</a>
                    <a class="dropdown-item" href="{{ route('funs.index') }}"><i class="fas fa-trophy"></i> 指定管理</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-desktop"></i> 網站設定x</a>
                  </div>
                </li>
              @endif

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user"></i> {{ auth()->user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('userData') }}"><i class="fas fa-cog"></i> 個人設定</a>
                    <a class="dropdown-item" href="#" onclick="bbconfirm_Form('logout-form','要登出了？')">
                      <i class="fas fa-sign-out-alt"></i> 登出
                    </a>
                </div>
              </li>
            @else
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> 登入</a></li>
            @endif
          </ul>
        </div>
      </div>
    </nav>
    @if(auth()->check())
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
    @endif
    @yield('content')
    <br>
    <br>
    <!-- 記得要把按鈕放到網頁上, 否則它不會出現 -->
    <a href="https://www.blogger.com/blogger.g?blogID=2031514508322140995#" id="gotop">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; {{ env('APP_NAME') }} 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    @include('layouts.bootbox')

    <!-- Bootstrap core JavaScript -->

    <script src="{{ asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{ asset('theme/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom JavaScript for this theme -->
    <script src="{{ asset('theme/js/scrolling-nav.js') }}"></script>

    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            /* 按下GoTop按鈕時的事件 */
            $('#gotop').click(function(){
                $('html,body').animate({ scrollTop: 0 }, 'slow');   /* 返回到最頂上 */
                return false;
            });

            /* 偵測卷軸滑動時，往下滑超過400px就讓GoTop按鈕出現 */
            $(window).scroll(function() {
                if ( $(this).scrollTop() > 400){
                    $('#gotop').fadeIn();
                } else {
                    $('#gotop').fadeOut();
                }
            });
        });
    </script>

  </body>

</html>

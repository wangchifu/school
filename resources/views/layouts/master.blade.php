<?php
  $setup = \App\Setup::first();
  $setup_key = "setup".$setup->id;
if(!session($setup_key)){
    $att['views'] = $setup->views+1;
    $setup->update($att);
}
session([$setup_key => '1']);

foreach(config('app.modules') as $v){
    if(strpos($setup->modules, $v) !== false){
        $check[$v] = "checked";
    }else{
        $check[$v] = "";
    }
}

$nav_color = (empty($setup->nav_color))?"navbar-dark bg-dark":"navbar-custom";
$navbar_custom = (empty($setup->nav_color))?['0'=>'','1'=>'','2'=>'','3'=>'']:explode(",",$setup->nav_color);


$logo = "title_image/logo.ico";
$logo = str_replace('/','&',$logo);

?>
<!DOCTYPE html>
<html lang="zh-TW">

  <head>
    <link rel="Shortcut Icon" type="image/x-icon" href="{{ url('img/'.$logo) }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('page-title') | {{ env('APP_SNAME') }}</title>

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


    .navbar-custom {
      background-color: {{ $navbar_custom[0] }};
    }
    /* change the brand and text color */
    .navbar-custom .navbar-brand,
    .navbar-custom .navbar-text {
      color: {{ $navbar_custom[1] }};
    }
    /* change the link color */
    .navbar-custom .navbar-nav .nav-link {
      color: {{ $navbar_custom[2] }};
    }
    /* change the color of active or hovered links */
    .navbar-custom .nav-item.active .nav-link,
    .navbar-custom .nav-item:hover .nav-link {
      color: {{ $navbar_custom[3] }};
    }
  </style>

  <!-- Navigation -->
    <nav class="navbar navbar-expand-lg {{ $nav_color }} fixed-top" id="mainNav">
      <div class="container">
      @if(file_exists(storage_path('app/public/title_image/logo.ico')))
        <a href="#page-top">
          <img src="{{ url('img/'.$logo) }}" width="30" height="30" class="d-inline-block align-top" alt="">
        </a>　
      @endif
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
                @if($check['meetings'])
                  <a class="dropdown-item" href="{{ route('meetings.index') }}"><i class="fas fa-comments"></i> 會議文稿</a>
                @endif
                @if($check['school_plans'])
                  <a class="dropdown-item" href="{{ route('school_plans.index') }}"><i class="fas fa-book"></i> 校務計畫</a>
                @endif
                @if($check['tests'])
                  <a class="dropdown-item" href="{{ route('tests.index') }}"><i class="far fa-check-square"></i> 問卷系統</a>
                @endif
                @if($check['classroom_orders'])
                  <a class="dropdown-item" href="{{ route('classroom_orders.index') }}"><i class="fas fa-list-ol"></i> 教室預約</a>
                @endif
                @if($check['fixes'])
                  <a class="dropdown-item" href="{{ route('fixes.index') }}"><i class="fas fa-wrench"></i> 報修系統</a>
                @endif
                @if($check['students'])
                  <a class="dropdown-item" href="{{ route('students.index') }}"><i class="fas fa-child"></i> 學生系統</a>
                @endif
                @if($check['lunches'])
                  <a class="dropdown-item" href="{{ route('lunches.index') }}"><i class="fas fa-utensils"></i> 午餐系統</a>
                @endif
                @if($check['sports'])
                  <a class="dropdown-item" href="#"><i class="fas fa-football-ball"></i> 運動會報名系統x</a>
                @endif
                @if($check['rewards'])
                  <a class="dropdown-item" href="#"><i class="fas fa-certificate"></i> 定期評量獎狀x</a>
                @endif
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
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              @foreach($in_link as $k=>$v)
                <a class="dropdown-item" href="{{ $v }}" target="_blank">{{ $k }}</a>
              @endforeach
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-external-link-square-alt"></i> 校外系統
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              @foreach($out_link as $k=>$v)
                  <a class="dropdown-item" href="{{ $v }}" target="_blank">{{ $k }}</a>
              @endforeach
              </div>
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
                    <a class="dropdown-item" href="{{ route('setups.index') }}"><i class="fas fa-desktop"></i> 網站設定</a>
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
        <p class="m-0 text-center text-white">Copyright &copy; {{ env('APP_NAME') }} 自 {{ substr($setup->created_at,0,10) }} 參訪人數：{{ $setup->views }}</p>
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

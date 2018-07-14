<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('theme/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('theme/css/scrolling-nav.css') }}" rel="stylesheet">

    <!-- icons -->
    <link href="{{ asset('fontawesome/css/fontawesome-all.css') }}" rel="stylesheet">

    <script src="{{ asset('theme/vendor/jquery/jquery.min.js') }}"></script>

</head>

<body id="page-top" onload='window.print();'>
@yield('content')
</body>
</html>

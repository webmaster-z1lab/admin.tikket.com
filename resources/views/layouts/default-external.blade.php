<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>{{ \Meta::get('title') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    {!! \Meta::tags() !!}
    {!! \Meta::tag('csrf-token', csrf_token()) !!}

    <link rel="shortcut icon" href="{{ getenv('AWS_CDN_ENDPOINT') }}/images/tikket/ticket_gradient.png">

    <script defer src="{{ getenv('AWS_CDN_ENDPOINT') }}/vendor/pace/1.0.2/pace.min.js"></script>
    <link href="{{ getenv('AWS_CDN_ENDPOINT') }}/vendor/pace/1.0.2/pace-theme-flash.css" rel="stylesheet">

    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <link href="{{ getenv('AWS_CDN_ENDPOINT') }}/template/hyper/1.4.0/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="{{ getenv('AWS_CDN_ENDPOINT') }}/template/hyper/1.4.0/css/app.min.css" rel="stylesheet" type="text/css">

    @stack('stylesheet')
    @stack('defer-scripts')
</head>
<body class="enlarged" data-keep-enlarged="true">

<div class="wrapper">
    @include('layouts.components.sidebar')
    <div class="content-page">
        <div class="content">
            @include('layouts.components.header')

            @yield('content')
        </div>

        @include('layouts.components.footer')
    </div>
</div>

@include('layouts.components.right-sidebar')

<div class="rightbar-overlay"></div>

@routes()

<script src="{{ getenv('AWS_CDN_ENDPOINT') }}/template/hyper/1.4.0/js/app.min.js"></script>

@stack('scripts')
</body>
</html>

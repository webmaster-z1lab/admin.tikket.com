<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Title -->
    <title>{{ \Meta::get('title') }}</title>

    <!-- Meta Head -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

{!! \Meta::tags() !!}
{!! \Meta::tag('csrf-token', csrf_token()) !!}

<!-- Favicon -->
    <link rel="icon" href="{{ asset('images/z1lab/icon/favicon.png') }}">

    <!-- Load -->
    <script src="{{ asset('js/pace.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/pace-theme-flash.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('template/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/css/app.min.css') }}" rel="stylesheet" type="text/css">

    @stack('stylesheet')
</head>
<body class="authentication-bg">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <!-- Logo-->
                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                        <a href="{{ route('home') }}">
                            <span><img src="{{ asset('images/z1lab/logo/logo_full_white.svg') }}" alt="" height="40"></span>
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center mt-0 font-weight-bold">@yield('action')</h4>
                            <p class="text-muted mb-4">@yield('message')</p>
                        </div>

                        @yield('content')
                    </div>
                </div>

                @yield('complement')
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('template/js/app.min.js') }}"></script>

@stack('scripts')
</body>
</html>

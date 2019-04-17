@extends('layouts.default-internal')

@push('after-body-scripts')
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.2&appId=220391998884632&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
@endpush

@section('content')
    <div id="vue-event-administration" data="{{json_encode($event)}}"></div>
@endsection

@push('scripts')
    <script src="{{ mix("js/event/administration/main.js") }}"></script>
@endpush

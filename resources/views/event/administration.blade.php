@extends('layouts.default-internal')

@section('content')
    <div id="vue-event-administration" data="{{json_encode($event)}}"></div>
@endsection

@push('scripts')
    <script src="{{ mix("js/event/administration/main.js") }}"></script>
@endpush

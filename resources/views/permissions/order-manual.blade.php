@extends('layouts.default-external')

@section('content')
    <div id="vue-order-manual" data="{{json_encode($event)}}"></div>
@endsection

@push('scripts')
    <script src="{{ mix("js/event/permission/main.js") }}"></script>
@endpush

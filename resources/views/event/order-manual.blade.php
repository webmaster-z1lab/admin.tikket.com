@extends('layouts.default-external')

@section('content')
    <div id="vue-order-manual" data="{{json_encode($event)}}"></div>
@endsection

@push('scripts')
    <script src="{{ mix("js/event/order-manual/main.js") }}"></script>
@endpush

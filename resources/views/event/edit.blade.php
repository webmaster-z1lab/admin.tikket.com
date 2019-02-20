@extends('layouts.default-internal')

@section('content')
    <div id="vue-event-edit" data="{{json_encode($event)}}"></div>
@endsection

@push('scripts')
    <script src="{{ mix("js/event/edit/main.js") }}"></script>
@endpush

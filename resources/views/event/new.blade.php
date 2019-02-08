@extends('layouts.default')

@section('content')
    <div id="vue-event-new"></div>
@endsection

@push('scripts')
    <script src="{{ mix("js/event/new/main.js") }}"></script>
@endpush

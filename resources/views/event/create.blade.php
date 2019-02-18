@extends('layouts.default-external')

@section('content')
    <div id="vue-event-create"></div>
@endsection

@push('scripts')
    <script src="{{ mix("js/event/create/main.js") }}"></script>
@endpush

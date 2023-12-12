@extends('layouts.app')

@section('head')
    <link href="{{ url('css/manage.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/manage.js') }} defer></script>
@endsection


@section('content')
    <div>
        <h2>Manage Suggested Topics</h2>
        @include('partials.list_suggested_topics')
    </div>
@endsection

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/common.css') }}" rel="stylesheet">
        <link href="{{ url('css/manage.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/popup.css') }}" rel="stylesheet">
        <link href="{{ url('css/news.css') }}" rel="stylesheet">
        <script src="{{ url('js/profile.js') }}"></script>

        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
            <header>
                <h1><a href="{{ url('/news') }}">Thingy!</a></h1>
                    @if (Auth::user()->is_admin())
                    <a class="button" href="{{ url('/manage') }}"> Manage Users </a>
                    @endif
                    <a class="button"> About Us </a>
                    <a class="button"> Contact Us </a>
                    @if (Auth::check())
                    <a class="button" href="{{ url('/logout') }}"> Logout </a>
                    <a href="{{ route('profile', ['user' => Auth::user()]) }}">{{ Auth::user()->name }}</a>
                    @endif
            </header>
            @if (Auth::check())
            <nav>
                <a href="" class="button"> Create Post</a>
                <a href="" class="button"> Create Organization</a>
                @include('partials.topic_proposal')
                @if (Auth::user()->is_admin())
                    <a class="button" href="{{ route('manage_topic') }}"> Manage Topics</a>
                @endif
            </nav>
            @endif
            <main>
            <section id="content">
                @yield('content')
            </section>
            </main>
    </body>
</html>
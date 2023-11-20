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
        <link href="{{ url('css/create_news.css') }}" rel="stylesheet">
        <link href="{{ asset('css/common.css') }}" rel="stylesheet">
        <link href="{{ url('css/manage.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/popup.css') }}" rel="stylesheet">
        <link href="{{ url('css/news.css') }}" rel="stylesheet">
        <link href="{{ url('css/info.css') }}" rel="stylesheet">

        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
        <script type="text/javascript" src={{ url('js/tags.js') }} defer></script>
    </head>
    <body>
            <header>
                <h1><a href="{{ url('/news') }}">NewsCore</a></h1>
                    <a href=" {{ url('/about_us') }}" class="button"> About Us </a>
                    <a href=" {{ url('/contacts') }}" class="button"> Contact Us </a>
                    @if (Auth::check())
                    <a class="button" href="{{ url('/logout') }}"> Logout </a>
                    <a href="{{ route('profile', ['user' => Auth::user()]) }}">{{ Auth::user()->name }}</a>
                    @endif
            </header>
            @if (Auth::check())
            <nav>
                @if (Auth::user()->is_admin())
                    <section id="admin_buttons">
                        <a class="button admin_button" href="{{ route('manage_topic') }}"> Manage Topics</a>
                        <a class="button admin_button" href="{{ url('/manage') }}"> Manage Users </a>
                    </section>
                @endif
                <a href="{{route('create_news')}}" class="button"> Create Post</a>
                <a href="" class="button"> Create Organization</a>
                @include('partials.topic_proposal')
            </nav>
            @endif
            <main>
            <section id="content">
                @yield('content')
            </section>
            </main>
    </body>
</html>
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
    <link href="{{ url('css/create_news.css') }}" rel="stylesheet">

    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/common.css') }}" rel="stylesheet">
    <link href="{{ url('css/manage.css') }}" rel="stylesheet">
    <link href="{{ url('css/profile.css') }}" rel="stylesheet">
    <link href="{{ url('css/popup.css') }}" rel="stylesheet">
    
    <link href="{{ url('css/news.css') }}" rel="stylesheet">
    <link href="{{ url('css/comments.css') }}" rel="stylesheet">
    <link href="{{ url('css/feed.css') }}" rel="stylesheet">

    <link href="{{ url('css/info.css') }}" rel="stylesheet">

    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/tags.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/topic.js') }} defer></script>

</head>

<body>
    <header>
        <h1><a href="{{ url('/news') }}">NewsCore</a></h1>
        <form action="/news" style="margin: 0;margin-left: 2rem; margin-right:1rem; display:flex;">
            <select name="search_type"
                style="background-color: white;width:auto;margin:0;background-position-x: calc(100% + 0.5em);">
                <option value="normal" @if (app('request')->input('search_type') == 'normal') selected @endif>Normal</option>
                <option value="exact" @if (app('request')->input('search_type') == 'exact') selected @endif>Exact</option>
            </select>
            <input type="text" name="search" value="{{ app('request')->input('search') }}"
                style="background-color: white;margin: 0;" placeholder="Search">
            <button type="submit" style="margin-bottom: 0;"><svg focusable="false" style="scale: 2;"
                    xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                    </path>
                </svg></button>
        </form>
        <span class="header_nav">
            <a href=" {{ url('/about_us') }}" class="button"> About Us </a>
            <a href=" {{ url('/contacts') }}" class="button"> Contact Us </a>
            @if (Auth::check())
                <a class="button" href="{{ url('/logout') }}"> Logout </a>
                <a class="button" id="button_profile" href="{{ route('profile', ['user' => Auth::user()]) }}">{{ Auth::user()->name }}</a>
            @endif
            @if (!Auth::check())
                <a class="button" href="{{ url('/login') }}">Log in</a>
                <a class="button" href="{{ url('/register') }}">Sign Up</a>
            @endif
        </span>
    </header>
    @if (Auth::check())
        <nav>
            @if (Auth::user()->is_admin())
                <section id="admin_buttons">
                    <a class="button admin_button" href="{{ route('manage_topic') }}"> Manage Topics</a>
                    <a class="button admin_button" href="{{ url('/manage') }}"> Manage Users </a>
                </section>
            @endif
            <a href="{{ route('create_news') }}" class="button"> Create Post</a>
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

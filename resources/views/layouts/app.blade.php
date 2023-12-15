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

    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/common.css') }}" rel="stylesheet">
    <link href="{{ url('css/popup.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <link href="{{ url('css/feed.css') }}" rel="stylesheet">
    
    <script src="https://kit.fontawesome.com/22c4374990.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/common.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/notification.js') }} defer></script>

    @yield('head')

</head>

<body>
    @include('partials.error_message')
    <header class="app_header">
    <input type="checkbox" id="hamburger">
    <label class="hamburger" for="hamburger"></label>
        <h1><a href="{{ url('/news') }}">NewsCore</a></h1>
        <form class="search_form" action="/news">
            <select name="search_type">
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
            @if (Auth::check())
                <a class="button" href="{{ url('/logout') }}"> Logout </a>
                <div class="header_user_info">
                    <a class="button" id="button_profile"
                        href="{{ route('profile', ['user' => Auth::user()]) }}">{{ Auth::user()->name }}<img
                            class="header_user_pfp" src="{{ Auth::user()->getProfileImage() }}"></a>
                </div>
                <button id="notification_icon"><span class="material-symbols-outlined">notifications</span></button>
            @else
                <a class="button" href="{{ url('/login') }}">Log in</a>
                <a class="button" href="{{ url('/register') }}">Sign Up</a>
            @endif
        </span>
    </header>
    <main>
    @if (Auth::check())
        <nav>
            <div class="sticky_nav">
                @if (Auth::user()->is_admin())
                    <section id="admin_buttons">
                        <a class="button admin_button" href="{{ route('manage_topic') }}"> Manage Topics</a>
                        <a class="button admin_button" href="{{ url('/manage') }}"> Manage Users </a>
                        <a class="button admin_button" id="manage_report_button"> Manage Report<span
                                class="material-symbols-outlined">expand_more</span></a>
                        <div class="sub-options" id="report_sub_options">
                            <a class="button" href="{{ route('user_reports') }}">Users</a>
                            <a class="button" href="{{ route('news_reports') }}">News</a>
                            <a class="button" href="{{ route('comments_reports') }}">Comments</a>
                            <a class="button" href="{{ route('news_reports') }}">Tags</a>
                        </div>
                    </section>
                @endif
                <section id="nav_normal_buttons">
                    <a href="{{ route('create_news') }}" class="button"> Create Post</a>
                    <a href="" class="button"> Create Organization</a>
                    <a class="button" onclick="openTopicProposal()">Propose New Topic</a>
                </section>
            </div>
        </nav>
    @endif
        <section id="content">
            @yield('content')
        </section>

        @if (Auth::check())
            <div id="notifications_pop_up">
                <?php $notifications = Auth::user()->notified_ordered; ?>
                @foreach ($notifications as $notif)
                    <article class="user_news" id="{{ $notif->notification->id }}">
                        <h4>
                            <button class="notification_button"><span
                                    class="material-symbols-outlined icon_red">delete</span></button>
                            @if ($notif->notification->type === 'follow')
                                <a
                                    href="{{ route('profile', ['user' => $notif->notification->user]) }}">{{ $notif->notification->user->name }}</a>
                                is following you !
                            @endif
                            @if ($notif->notification->type === 'content')
                                <a
                                    href="{{ route('news_page', ['id' => $notif->notification->content->comments->news_item->id]) }}">{{ $notif->notification->content->comments->news_item->title }}</a>
                                has a new comment, go check !
                            @endif
                        </h4>
                    </article>
                @endforeach
                <a href="{{ url('/notification') }}"> See More </a>
            </div>
        @endif

    </main>
    <footer>
        <a href=" {{ url('/about_us') }}"> About Us </a>
        <h3><a href="{{ url('/news') }}">NewsCore</a></h3>
        <a href=" {{ url('/contacts') }}"> Contact Us </a>
    </footer>
</body>

</html>

@include('partials.topic_proposal')

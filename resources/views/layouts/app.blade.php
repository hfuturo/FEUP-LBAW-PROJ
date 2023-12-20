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

    <link href="{{ url('css/common.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/popup.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <link href="{{ url('css/feed.css') }}" rel="stylesheet">

    <script src="https://js.pusher.com/7.0/pusher.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/22c4374990.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/common.js') }} defer></script>

    @if (Auth::check())
        <script type="text/javascript" src={{ url('js/notification.js') }} defer></script>
    @endif

    @yield('head')

</head>

<body>
    @include('partials.error_message')
    <header class="app_header">
        <a class="skip-to-content-link" href="#content">
            Skip to content
        </a>
        <div style="display: flex;">
            @if (Auth::check())
                <input type="checkbox" id="hamburger">
                <label class="hamburger" for="hamburger"></label>
            @endif
            <h1><a href="{{ url('/news') }}">NewsCore</a></h1>
        </div>
        <form class="search_form" action="/news">
            <a class="button button-secondary advanced_search_link material-symbols-outlined"
                href="{{ route('advanced_search') }}" title="Advanced search">settings</a>
            <input type="text" name="search" value="{{ app('request')->input('search') }}" placeholder="Search">
            <button class="button button-secondary" type="submit" title="Search"><svg focusable="false"
                    style="scale: 1.3;" xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                    </path>
                </svg></button>
        </form>
        <div class="header_nav">
            @if (Auth::check())
                <a class="button" href="{{ url('/logout') }}"> Logout </a>
                <div class="header_user_info">
                    <a class="button button-secondary" id="button_profile"
                        href="{{ route('profile', ['user' => Auth::user()]) }}">{{ Auth::user()->name }}
                        <img alt="{{ Auth::user()->name }}" class="header_user_pfp"
                            src="{{ Auth::user()->getProfileImage() }}"></a>
                </div>
                @if (count(Auth::user()->new_notifications) === 0)
                    <button id="notification_icon"><span class="material-symbols-outlined">notifications</span></button>
                @else
                    <button id="notification_icon"><span
                            class="material-symbols-outlined">notifications_unread</span></button>
                @endif
            @else
                <a class="button" href="{{ url('/login') }}">Log in</a>
                <a class="button" href="{{ url('/register') }}">Sign Up</a>
            @endif
        </div>
    </header>
    <main>
        @if (Auth::check())
            <nav>
                <div class="sticky_nav">
                    @if (Auth::user()->is_admin())
                        <div id="admin_buttons">
                            <a class="button admin_button" href="{{ route('unblock_appeals') }}">Manage unblock
                                appeals</a>
                            <a class="button admin_button" href="{{ route('manage_topic') }}"> Manage Topics</a>
                            <a class="button admin_button" href="{{ route('list_mods') }}"> Manage Moderators</a>
                            <a class="button admin_button" href="{{ url('/manage') }}"> Manage Users </a>
                            <button class="button admin_button" id="manage_report_button"> Manage Report<span
                                    class="material-symbols-outlined">expand_more</span></button>
                            <div class="sub-options" id="report_sub_options">
                                <a class="button button-secondary" href="{{ route('user_reports') }}">Users</a>
                                <a class="button button-secondary" href="{{ route('news_reports') }}">News</a>
                                <a class="button button-secondary" href="{{ route('comments_reports') }}">Comments</a>
                                <a class="button button-secondary" href="{{ route('news_reports') }}">Tags</a>
                            </div>
                        </div>
                    @endif
                    <div id="nav_normal_buttons">
                        <a href="{{ route('create_news') }}" class="button"> Create Post</a>
                        <button class="button open" onclick="openNewOrg()"> Create Organization</button>
                        <button class="button" onclick="openTopicProposal()">Propose New Topic</button>
                    </div>
                </div>
            </nav>
        @endif
        <section id="content">
            @yield('content')
            @if (Auth::check())
                @include('partials.create_organization')
                <div id="notifications_pop_up">
                    <?php $notifications = Auth::user()->notified_ordered->take(5); ?>
                    @if (count($notifications) === 0)
                        <p>There are no notifications to show.</p>
                    @else
                        @foreach ($notifications as $notif)
                            <article
                                @if (!$notif->view) class="user_news new_notification" @else class="user_news" @endif
                                id="{{ $notif->notification->id }}">
                                <div>
                                    <button class="notification_button"><span
                                            class="material-symbols-outlined icon_red">delete</span></button>
                                    @if ($notif->notification->type === 'follow')
                                        <div>
                                            <a
                                                href="{{ route('profile', ['user' => $notif->notification->user]) }}">{{ $notif->notification->user->name }}</a>
                                            is following you !
                                        </div>
                                    @endif
                                    @if ($notif->notification->type === 'content')
                                        <div>
                                            <a
                                                href="{{ route('news_page', ['id' => $notif->notification->content->comments->news_item->id]) }}">{{ $notif->notification->content->comments->news_item->title }}</a>
                                            has a new comment, go check !
                                        </div>
                                    @endif
                                    @if ($notif->notification->type === 'vote')
                                        <div>
                                            <a
                                                href="{{ route('profile', ['user' => $notif->notification->user]) }}">{{ $notif->notification->user->name }}</a>
                                            voted on your news item. <a
                                                href="{{ route('news_page', ['id' => $notif->notification->content->news_items->id]) }}">{{ $notif->notification->content->news_items->title }}</a>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    @endif
                    <a href="{{ url('/notification') }}"> See More </a>
                </div>
            @endif
            @include('partials.topic_proposal')

        </section>

    </main>
    <footer>
        <a href=" {{ url('/about_us') }}"> About Us </a>
        <h3><a href="{{ url('/news') }}">NewsCore</a></h3>
        <a href=" {{ url('/contacts') }}"> Contact Us </a>
    </footer>
</body>

</html>

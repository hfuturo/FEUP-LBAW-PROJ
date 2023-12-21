@extends('layouts.app')

@section('head')
    <link href="{{ url('css/profile.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/profile.js') }} defer></script>
    <link href="{{ url('css/news.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/vote.js') }} defer></script>
@endsection

@section('content')
    <div class="user_page">
        <div class="profile" id={{ $user->id }}>
            <div id="user_card">
                <div class="action_buttons_wrapper">
                    @if (Auth::user()->id !== $user->id)
                        @include('partials.report_user')
                    @endif
                    @if (Auth::user()->id === $user->id || Auth::user()->is_admin())
                        <button class="delete_button delete_user_button">Delete Account</button>
                    @endif
                    @if (Auth::user()->id !== $user->id && Auth::user()->is_admin())
                        @if ($user->blocked)
                            <button class="delete_button unblock_user_button">Unblock Account</button>
                        @else
                            <button class="delete_button block_user_button">Block Account</button>
                        @endif
                    @endif
                </div>
                @if (Auth::user()->id === $user->id)
                    @include('partials.edit_profile', ['user' => $user])
                @else
                    <div class="user_follow_edit">
                        <h2>{{ $user->name }}</h2>
                        @include('partials.follow_user')
                    </div>
                @endif
                <div id="user_details">
                    <div class="user_info">
                        <h4>Reputation</h4>
                        <p>{{ $user->reputation }}</p>
                    </div>
                    <div class="user_info">
                        <h4>Followers</h4>
                        <p id="folowers_count">{{ $user->followers()->count() }}</p>
                    </div>
                    <div class="user_info">
                        <h4>Following</h4>
                        <p>{{ $user->following()->count() }}</p>
                    </div>
                </div>
                <div class="user_info">
                    <h4>Bio</h4>
                    <p>
                        @if ($user->bio !== '')
                            {{ $user->bio }}
                        @else
                            There is no Bio
                        @endif
                    </p>
                </div>
                <div class="user_info">
                    <h4>Organizations</h4>
                    <p>
                        @if ($user->organizations->count() !== 0)
                            @foreach ($user->organizations as $org)
                                <a href="{{ route('show_org', ['organization' => $org->id]) }}">{{ $org->name }}</a>
                            @endforeach
                        @else
                            Doesn't belong to any organization.
                        @endif
                    </p>
                </div>
            </div>
            <div class="image_wrapper">
                <img id="user_picture" src="{{ $user->getProfileImage() }}" alt="Profile Picture">
                @if (Auth::user()->id === $user->id)
                    <div class="image_buttons_wrapper">
                        @include('partials.image_form')
                        <button class="remove_pfp_image delete_button button">Remove image</button>
                    </div>
                @endif
            </div>
        </div>
        <h3>News made by {{ $user->name }} ...</h3>
        <div>
            @if ($user->news_items()->get()->isEmpty())
                <p>There is no news created by this user.</p>
            @else
                @include('partials.list_feed', [
                    'news_list' => $user->news_items()->join('news_item', 'content.id', '=', 'news_item.id'),
                    'perPage' => 5,
                ])
            @endif
        </div>
    </div>
@endsection

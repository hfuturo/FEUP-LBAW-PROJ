@extends('layouts.app')

@section('head')
    <link href="{{ url('css/profile.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/profile.js') }} defer></script>
@endsection

@section('content')
    <div class="user_page">
        <div class="profile">
            <div id="user_card">
                <div class="action_buttons_wrapper">
                    @if (Auth::user()->id !== $user->id)
                        @include('partials.report_user')
                    @endif
                    @if (Auth::user()->id === $user->id || Auth::user()->is_admin())
                        @include('partials.delete_account', ['user' => $user])
                    @endif
                    @if (Auth::user()->id !== $user->id && Auth::user()->is_admin())
                        @if ($user->blocked)
                            @include('partials.unblock_user', ['user' => $user])
                        @else
                            @include('partials.block_user', ['user' => $user])
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
            </div>
            <div class="image_wrapper">
                <img id="user_picture" src="{{ $user->getProfileImage() }}" alt="Profile Picture">
                @if (Auth::user()->id === $user->id)
                    <div class="image_buttons_wrapper">
                        @include('partials.image_form')
                        @include('partials.remove_pfp_form')
                    </div>
                @endif
            </div>
        </div>
        <h3>News made by {{ $user->name }} ...</h3>
        <div>
            @if ($user->news_items()->get()->isEmpty())
                <p>There is no news created by this user.</p>
            @else
                @include('partials.list_news', ['news_list' => $user->news_items(), 'perPage' => 5])
            @endif
        </div>
    </div>
@endsection

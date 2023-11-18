@extends('layouts.app')

@section('content')
<div class="user_page">
    <div class="profile">
        <div id="user_card">
            <h2>{{ $user->name }}</h2>
            <div id="user_details">
                <div id="user_info">
                    <h4>Reputation</h4>
                    <p>{{ $user->reputation }}</p>    
                </div>
                <div id="user_info">
                    <h4>Followers</h4>
                    <p>{{ $user->followers()->count() }}</p>    
                </div>
                <div id="user_info">
                    <h4>Following</h4>
                    <p>{{ $user->following()->count() }}</p> 
                </div>
            </div>
            <div id="user_info">
                <h4>Bio</h4>
                <p>
                    @if ($user->bio !== '')
                        <!-- There is bio -->
                        {{ $user->bio }}
                    @else
                        <!-- There is no bio -->
                        There is no Bio
                    @endif
                </p>
            </div>
        </div>
        <img id="user_picture" src="https://api.lorem.space/image/movie?w=150&amp;amp;amp;amp;h=220">
    </div>
    <h3>News made by {{ $user->name }} ...</h3>
    <div>
        @if ($user->news_items()->get()->isEmpty())
            <p>There is no news created by this user.
        @else
            @include('partials.list_news', ['news_list' => $user->news_items(), 'perPage' => 5])
        @endif
    </div>
</div>
@endsection
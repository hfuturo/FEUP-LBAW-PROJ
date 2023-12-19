@extends('layouts.app')

@section('head')
    <link href="{{ url('css/organization.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/organization.js') }} defer></script>
    <link href="{{ url('css/news.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/vote.js') }} defer></script>
@endsection

@section('content')
    <section id="org_info">
        <div class="header">
            <h3>{{ $organization->name }}</h3>
            <div>
                <input type="hidden" id="org" name="org" value="{{ $organization->id }}">
                <?php $follow_org = Auth::user()->follow_organizations()->where('id_organization', $organization->id)->first();?>
                @if ($follow_org)
                    <button class="button" id="follow" data-operation="unfollow">Unfollow</button>
                @else
                    <button class="button" id="follow" data-operation="follow">Follow</button>
                @endif
                <?php $status = Auth::user()->membershipStatuses()->where('id_organization', $organization->id)->first();?>
                @if ($status)
                    @if($status->member_type == 'leader')
                    <button class="button" id="status"data-operation="destroy">Leave</button>
                    <a class="button" href="{{route('show_manage_org', ['organization' => $organization->id])}}">Manage</a>
                    @elseif ($status->member_type == 'member')
                    <button class="button" id="status"data-operation="destroy">Leave</button>
                    @elseif ($status->member_type == 'asking')
                    <button class="button" id="status" data-operation="destroy">Delete Request</button>
                    @elseif ($status->member_type == 'invited')
                    <button class="button" id="status" data-operation="update">Accept Request</button>
                    <button class="button" id="status" data-operation="destroy">Reject Request</button>
                    @endif
                @else
                <button class="button" id="status" data-operation="create">Ask to Join</button>
                @endif
            </div>
        </div>
        <p>{{ $organization->bio }}</p>
        <div id="followers_members">
            <button class="button"><span>Followers </span><span>{{ $organization->followers->count() }}</span></button>
            <button class="button" onclick="openMembersOrg()"><span>Members </span><span id="numberMembers">{{ $organization->members->count() }}</span></button>
            @include('partials.organization_members')
        </div>
    </section>
    <section id="org_feed">
        <h3>News Related to this organization ...</h3>
        @if ($organization->contents()->get()->isEmpty())
            <p>There is no news releted to this organization</p>
        @else
            @include('partials.list_news', ['news_list' => $organization->contents(), 'perPage' => 5])
        @endif
    </section>
@endsection

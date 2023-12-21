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
            <h3 id="nameDisplayed">{{ $organization->name }}</h3>
            <div>
                <input type="hidden" id="org" name="org" value="{{ $organization->id }}">
                <?php $follow_org = Auth::user()
                    ->follow_organizations()
                    ->where('id_organization', $organization->id)
                    ->first(); ?>
                @if ($follow_org)
                    <button class="button" id="follow" data-operation="unfollow">Unfollow</button>
                @else
                    <button class="button" id="follow" data-operation="follow">Follow</button>
                @endif
                <?php $status = Auth::user()
                    ->membershipStatuses()
                    ->where('id_organization', $organization->id)
                    ->first(); ?>
                @if ($status)
                    @if ($status->member_type == 'leader')
                        <button class="button" id="status"data-operation="destroy">Leave</button>
                        <button class="button" onclick="openEditForm()">Edit</button>
                        @include('partials.edit_organization')
                        @if (!Auth::user()->is_admin())
                            <a class="button"
                                href="{{ route('show_manage_org', ['organization' => $organization->id]) }}">Manage</a>
                        @endif
                    @elseif ($status->member_type == 'member')
                        <button class="button" id="status"data-operation="destroy">Leave</button>
                    @elseif ($status->member_type == 'asking')
                        <button class="button" id="status" data-operation="destroy">Delete Request</button>
                    @endif
                @else
                    <button class="button" id="status" data-operation="create">Ask to Join</button>
                @endif
                @if (Auth::user()->is_admin())
                    <a class="button"
                        href="{{ route('show_manage_org', ['organization' => $organization->id]) }}">Manage</a>
                @endif
            </div>
        </div>
        <p id="bioDisplayed">{{ $organization->bio }}</p>
        <div id="followers_members">
            <button class="button" onclick="openMembersOrg()"><span>Members </span><span
                    id="numberMembers">{{ $organization->members->count() }}</span></button>
            <span>Followers </span><span>{{ $organization->followers->count() }}</span></button>
            @include('partials.organization_members')
        </div>
    </section>
    <section id="org_feed">
        <h3>News Related to this organization ...</h3>
        @if ($organization->contents()->get()->isEmpty())
            <p>There is no news releted to this organization</p>
        @else
            @include('partials.list_feed', [
                'news_list' => $organization->contents()->join('news_item', 'content.id', '=', 'news_item.id'),
                'perPage' => 5,
            ])
        @endif
    </section>
@endsection

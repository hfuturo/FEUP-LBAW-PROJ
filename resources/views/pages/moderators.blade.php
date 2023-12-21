@extends('layouts.app')

@section('head')
    <link href="{{ url('css/moderator.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/moderator.js') }} defer></script>
@endsection

@section('content')
    <section id="topics">
        @foreach ($topics as $topic)
            <article class="topic" id-topic="{{ $topic->id }}">
                <div>
                    <h3><a href="{{ route('topic', ['topic' => $topic]) }}">{{ $topic->name }}</a></h3>
                    <span class="nMods" value="{{ $topic->moderators->count() }}">({{ $topic->moderators->count() }})</span>
                    <button class="button button_plus" onclick="openMakeModeratorUser(this)"><i
                            class="fa-solid fa-plus"></i></button>
                </div>
                <ul>
                    @if ($topic->moderators->count() === 0)
                        <li>This topic has no moderators</li>
                    @else
                        @foreach ($topic->moderators as $moderator)
                            <li class="moderator" id="{{ $moderator->id }}">
                                <a href="{{ route('profile', ['user' => $moderator]) }}">{{ $moderator->name }}</a>
                                <button onclick="revokeModerator2(this)" class="button">Revoke privileges</button>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </article>
        @endforeach
    </section>
    <script>
        const allUsers = [
            @foreach ($users as $user)
                {
                    id: {{ $user->id }},
                    html: `<option value="{{ $user->id }}">{{ $user->name }}</option>`
                },
            @endforeach
        ]

        function openAddModeratorTopicForm(id) {
            Swal.fire({
                title: "Select an user to become moderator",
                html: `<form id="choose_user_form">
                @csrf
                <input type="hidden" name="topic" id="id_topic" value="${id}">
                <select id="select_user" name="user">
                    ${allUsers.map(user=>user.html).join("")}
                </select>
            </form>`,
                confirmButtonColor: 'var(--primary-color)',
                customClass: {
                    confirmButton: "button",
                    cancelButton: "button",
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                didOpen: () => {
                    const popup = Swal.getPopup()
                    popup.querySelector("form").addEventListener("submit", Swal.clickConfirm)
                },
                preConfirm: () => {
                    const popup = Swal.getPopup()
                    const form = popup.querySelector("form")
                    if (form.reportValidity()) {
                        const select = form.querySelector('[name="user"]')
                        makeModerator2Submit(getFormParams(form), select.options[select.selectedIndex]
                            .textContent);
                        return true;
                    }
                    return false;
                }
            })
        }
    </script>
@endsection

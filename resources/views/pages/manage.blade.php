@extends('layouts.app')

@section('head')
    <link href="{{ url('css/manage.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/moderator.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/manage.js') }} defer></script>
@endsection

@section('content')
    <section id="users">
        <h2>List of Users</h2>
        <input id="filter_users" name="filter_users" placeholder="User's name">
        <nav id="all_users">
            @each('partials.manage', $users, 'user')
        </nav>
    </section>
    <script>
        function openMakeModeratorTopicForm(id) {
            Swal.fire({
                title: "Report",
                html: `
            <form id="choose_topic_form">
                @csrf
                <input type="hidden" name="user" id="id_user" value="${id}">
                <label>What topic will moderate?</label>
                <select id="select_topic" name="topic">
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
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
                        const select = form.querySelector('[name="topic"]')
                        makeModeratorSubmit(id, getFormParams(form), select.options[select.selectedIndex]
                            .textContent);
                        return true;
                    }
                    return false;
                }
            })
        }
    </script>
@endsection

@if ($suggested_topic->get()->isEmpty())
    There is no suggested topic ...
@else
    @foreach ($suggested_topic->paginate(5) as $topic)
        <article class="user_news topics_proposal" id="{{ $topic->id }}">
            <h4>Name: {{ $topic->name }}</h4>
            <p>
                Author:
                <a href="{{ route('profile', ['user' => $topic->id_user]) }}">{{ $topic->user_name }}</a>
            </p>
            <p>Justification: {{ $topic->justification }}
            <p>
                <span id="container_choices">
                    <button class="accept" data-operation="accept_suggested_topic"><span class="material-symbols-outlined">done</span></button>
                    <button class="remove" data-operation="delete_suggested_topic"><span class="material-symbols-outlined">close</span></button>
                </span>
            </p>
        </article>
    @endforeach
@endif
<span>{{ $suggested_topic->paginate(5)->links() }}</span>

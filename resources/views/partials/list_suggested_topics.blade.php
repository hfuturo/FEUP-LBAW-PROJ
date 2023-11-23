@if ($suggested_topic->get()->isEmpty())
    There is no suggested topic ...
@else
    @foreach ($suggested_topic->paginate(5) as $topic)
        <article class="user_news topics_proposal" id="{{ $topic->id }}">
            <h4>Name: {{ $topic->name }}<h4>
            <p>
                Author: 
                <a href="{{ route('profile', ['user' => $topic->id_user]) }}">{{ $topic->user_name }}</a>
            </p>
            <p>Justification: {{ $topic->justification }}<p>
            <button class="button accept" data-operation="accept_suggested_topic">Accept</button>
            <button class="button remove" data-operation="delete_suggested_topic">Remove</button>
        </article>
    @endforeach
@endif
<span>{{ $suggested_topic->paginate(5)->links() }}</span>
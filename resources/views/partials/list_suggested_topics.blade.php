@if ($suggested_topic->get()->isEmpty())
    There is no suggested topic ...
@else
    @foreach ($suggested_topic->paginate(5) as $topic)
        <article class="user_news">
            <h4>Name: {{ $topic->name }}<h4>
            <p>
                Author: 
                <a href="{{ route('profile', ['user' => $topic->id_user]) }}">{{ $topic->user_name }}</a>
            </p>
            <p>Justification: {{ $topic->justification }}<p>
            <form action="{{ route('accept_suggested_topic', ['name' => $topic->name]) }}" method="post">
                @csrf
                <button class="button accept" type="submit">Accept</button>
            </form>
            <form action="{{ route('delete_suggested_topic', ['topic' => $topic->id]) }}" method="post">
                @csrf
                <button class="button remove" type="submit">Remove</button>
            </form>
    </article>
    @endforeach
@endif
<span>{{ $suggested_topic->paginate(5)->links() }}</span>
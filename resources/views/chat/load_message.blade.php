@foreach($conversation->messages as $message)
<div class="message-item @if($message->user->id == Auth::user()->id) out @else in @endif">
    <div class="message-avatar">
        <figure class="avatar avatar-sm">
            <img src="{{ asset($message->user->photo->url ?? ($message->user->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')) }}" class="rounded-circle" alt="image">
        </figure>
        <div>
            <h5>{{ $message->user->first_name }} {{ $message->user->last_name }}</h5>
            <div class="time"><time class="timeago" datetime="{{ \Carbon\Carbon::parse($message->created_at)->timezone($message->user->timezone->code) }}">{{ \Carbon\Carbon::parse($message->created_at)->timezone($message->user->timezone->code)->diffForHumans() }}</time></div>
        </div>
    </div>
    <div class="message-content">
        <div class="message-text">{{ $message->message }}</div>
    </div>
</div>
@endforeach
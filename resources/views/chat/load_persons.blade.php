<ul class="list-group list-group-flush">
@foreach($conversations as $conversation)
<li class="list-group-item @if($conversation->me()->unread > 0) unread-chat @endif" id="c_{{ $conversation->id }}">
    @if(!$conversation->title)
    <div class="avatar-group">
        <figure class="avatar avatar-{{ $conversation->other()->user->id }} @if($conversation->other()->user->online){{ 'avatar-state-success'}}@endif" data-toggle="tooltip" title="{{ $conversation->other()->user->first_name }}">
            <img src="{{ asset($conversation->other()->user->photo->url ?? ($conversation->other()->user->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')) }}" class="rounded-circle" alt="image">
        </figure>
    </div>        
    @endif  
    
    <div class="users-list-body">
        <div>
            <h5>
            @if($conversation->title)
                {{ $conversation->title }}
            @else
                {{ $conversation->other()->user->first_name }}
            @endif
            </h5>
            <p>{{ $conversation->last_message()->user->first_name }}: {{ $conversation->last_message()->message }}</p>
        </div>
        <div class="users-list-action">
            @if($conversation->me()->unread > 0)
            <div class="new-message-count">{{ $conversation->me()->unread }}</div>
            @endif
            <small class="text-muted">{{ \Carbon\Carbon::parse($conversation->last_message()->created_at)->diffForHumans() }}</small>
        </div>
    </div>
    
</li>
@endforeach
</ul>
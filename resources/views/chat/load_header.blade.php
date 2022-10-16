<div class="chat-header-user">
    @if(!$conversation->title)
    <figure class="avatar avatar-{{ $conversation->other()->user->id }} @if($conversation->other()->user->online){{ 'avatar-state-success'}}@endif">
        <img src="{{ asset($conversation->other()->user->photo->url ?? ($conversation->other()->user->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')) }}" class="rounded-circle" alt="image">
    </figure>
    @endif  
    <div>
        <h5>
        @if($conversation->title)
            {{ $conversation->title }}
        @else
            {{ $conversation->other()->user->first_name }}
        @endif        
        </h5>
        @if($conversation->other()->user->online == false)
        <small class="isOnline-{{ $conversation->other()->user->id }} text-secondary">Çevrimdışı</small>
        @else
        <small class="isOnline-{{ $conversation->other()->user->id }} text-success">Çevrimiçi</small>
        @endif        
    </div>
</div>
<div class="chat-header-action">
    <ul class="list-inline">
        <li class="list-inline-item d-inline d-lg-none">
            <a href="#" class="btn btn-danger btn-floating example-chat-close">
                <i class="mdi mdi-arrow-left"></i>
            </a>
        </li>
        <li class="list-inline-item">
            <a href="#" class="btn btn-dark btn-floating" data-toggle="dropdown">
                <i class="mdi mdi-dots-horizontal"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item example-close-selected-chat">Sohbeti kapat</a>
                <a href="#" class="dropdown-item example-delete-chat">Sohbeti sil</a>                            
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-danger example-block-user">Engelle</a>
            </div>
        </li>
    </ul>
</div>
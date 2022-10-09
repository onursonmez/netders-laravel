<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Netders - Mesajlar</title>

<!-- Google Nunito font -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap" rel="stylesheet">

<!-- Themify icons -->
<link href="{{ asset('vendor/chat/icons/themify/themify-icons.css') }}" rel="stylesheet">

<!-- Material design icons -->
<link href="{{ asset('vendor/chat/icons/materialicons/css/materialdesignicons.min.css') }}" rel="stylesheet">

<!-- Bundle styles -->
<link rel="stylesheet" href="{{ asset('vendor/chat/vendor/bundle.css') }}">

<!-- App styles -->
<link rel="stylesheet" href="{{ asset('vendor/chat/css/app-blue.css') }}">

<!-- Fancybox -->
<link rel="stylesheet" href="{{ asset('vendor/chat/vendor/fancybox/jquery.fancybox.min.css') }}" type="text/css"/>

</head>
<body>

<!-- preloader -->
<div class="preloader">
    <img src="{{ asset('img/netders-logo-blue.svg') }}" alt="logo" width="170">
    <p class="lead font-weight-bold text-muted my-5">Mesajlar yükleniyor ...</p>
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- ./ preloader -->


<!-- layout -->
<div class="layout">
    <!-- Chat left sidebar -->
    <div id="chats" class="left-sidebar open">
        
        <div class="left-sidebar-header">  
        <div class="story-block">
            <a href="{{ url('users/dashboard') }}">
                <img src="{{ asset('img/netders-logo-blue.svg') }}" alt="logo" width="170" class="mb-4">
            </a>
        </div>           
            <form autocomplete="off">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn" type="button">
                            <i class="ti-search"></i>
                        </button>
                    </div>
                    <input type="text" id="search" class="form-control" placeholder="Mesajlaşılan kişileri ara...">
                </div>
            </form>
        </div>
        <div class="left-sidebar-content" id="persons">
            
        </div>
    </div>
    <!-- ./ Chat left sidebar -->

    <!-- chat -->
    <div class="chat no-message"> <!-- no-message -->
        <div class="chat-preloader d-none">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="no-message-container">
            <div class="row mb-5">
                <div class="col-md-4 offset-4">
                    <img src="{{ asset('vendor/chat/media/svg/chat_empty.svg') }}" class="img-fluid" alt="image">
                </div>
            </div>
            <p class="lead">Sol menüden mesajlaşmak istediğin kişiyi seçebilirsin.</p>
        </div>
        <div class="chat-header">
            
        </div>

        <div class="chat-body">
            <div class="messages">
            </div>
        </div>

        <div class="chat-footer">
            <form class="d-flex" id="sendMessage" autocomplete="off">
                @csrf
                <input type="text" name="message" class="form-control form-control-main" placeholder="Mesaj yaz">
                <div>
                    <button class="btn btn- btn-primary ml-2 btn-floating" type="submit">
                        <i class="mdi mdi-send"></i>
                    </button>
                </div>
                <input type="hidden" name="conversation_id" id="conversation_id" value="" />
                <input type="hidden" name="from_avatar" id="from_avatar" value="{{ asset(Auth::user()->photo->url ?? (Auth::user()->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')) }}" />
                <input type="hidden" name="from_full_name" id="from_full_name" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" />
                
            </form>
        </div>
    </div>
    <!-- ./ chat -->

</div>
<!-- ./ layout -->

<!-- Bundle scripts -->
<script src="{{ asset('vendor/chat/vendor/bundle.js') }}"></script>

<!-- Feather icons -->
<script src="{{ asset('vendor/chat/icons/feather/feather.min.js') }}"></script>

<!-- Sweetalert2 -->
<script src="{{ asset('vendor/chat/vendor/sweetalert2.js') }}"></script>

<!-- Fancybox -->
<script src="{{ asset('vendor/chat/vendor/fancybox/jquery.fancybox.min.js') }}"></script>

<!-- Timeago -->
<script src="{{ asset('vendor/jquery-timeago/jquery.timeago.js') }}"></script>

<!-- Pusher -->
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<!-- Global scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- App scripts -->
<script src="{{ asset('vendor/chat/js/app.js') }}"></script>

<!-- Examples -->
<script src="{{ asset('vendor/chat/js/examples.js') }}"></script>

<script>
    Pusher.logToConsole = true;
</script>

</body>
</html>

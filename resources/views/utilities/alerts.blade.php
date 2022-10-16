@if($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger box-shadow alert-dismissible fade show" role="alert">
    {{ $error }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endforeach
@endif

@if(Session::has('messages'))
    @foreach(session()->get('messages')  as $message)
    <div class="alert alert-success box-shadow alert-dismissible fade show" role="alert">
    {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endforeach
@endif  
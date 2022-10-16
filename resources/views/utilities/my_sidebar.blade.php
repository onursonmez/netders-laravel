<div class="col-lg-3 d-none d-lg-block">
    @if(Auth::user()->status == 'A' && Auth::user()->is_teacher())
    <div class="alert alert-info box-shadow">
        <a href="{{ url(Auth::user()->username) }}" target="_blank">Profilim nasıl görünüyor?</a>
    </div>
    @endif 

    <div class="card box-shadow mb-4">
        <div class="card-header">
            <h4 class="mb-0 pt-3 pb-3">Menü</h4>
        </div>
        <div class="card-body">
            <ul class="list-unstyled text-small mb-0">
                @foreach(\App\Models\Content::menu() as $menu)
                    <li class="pt-2 pb-2 border-bottom"><a href="{{ $menu['url'] }}">{{ $menu['text'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    @if(Auth::user()->is_teacher())
    <div class="card box-shadow mb-4">
        <div class="card-body text-center">
            <span>Arama sonuçlarında ortalama</span>
            <h1 class="mt-2">{{ Auth::user()->rank(Auth::user()) }}.</h1>
            <span>sırada yer alıyorsun.</span>
            <br />
            <small><a href="{{ url('yardim/arama-sonuclari-siralamasi-nasil-belirleniyor.html') }}">Bu nedir?</a></small>
        </div>
    </div>            
    @endif  
</div>
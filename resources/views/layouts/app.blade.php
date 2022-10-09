<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
@if(isset($seo_title) || Route::currentRouteName() == 'welcome')
<title>{{ $seo_title ?? env('APP_SEO_TITLE') }}</title>
@endif
@if(
    Route::currentRouteName() != 'users/search' &&
    Route::currentRouteName() != 'dynamic' &&
    Route::currentRouteName() != 'prices/detail'
)
<meta name="description" content="{{ $seo_description ?? env('APP_SEO_DESCRIPTION') }}" />
<meta name="keywords" content="{{ $seo_keyword ?? '' }}" />
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta property="og:url"           content="{{ URL::current() }}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{ $seo_title ?? config('app.APP_SEO_TITLE', 'Netders.com') }}" />
<meta property="og:description"   content="{{ $seo_description ?? config('app.APP_SEO_DESCRIPTION', 'Netders.com') }}" />
<meta property="og:image"         content="{{ asset('img/netders-logo-blue.png') }}" />

<link rel="canonical" href="{{ URL::current() }}">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/jgrowl/jquery.jgrowl.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/mmenu/mmenu.css') }}">
@if(Route::currentRouteName() == 'welcome')
<link rel="stylesheet" href="{{ asset('vendor/owl/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/owl/owl.theme.default.min.css') }}">
@endif

@if(Route::currentRouteName() == 'users/personal' || Route::currentRouteName() == 'dynamic' || Route::currentRouteName() == 'username/change' || Route::currentRouteName() == 'contents/contact')
<link rel="stylesheet" href="{{ asset('vendor/intl-tel-input/build/css/intlTelInput.css') }}">
@endif
@if(Route::currentRouteName() == 'users/search')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endif
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<!--[if lt IE 9]>
  <script src="{{ asset('vendor/html5shiv/html5shiv.min.js') }}"></script>
  <script src="{{ asset('vendor/respond/respond.min.js') }}"></script>
<![endif]-->
</head>
<body>
    @if(Route::currentRouteName() == 'users/search')
    <div class="overlay"></div>
    @endif
    <div class="container">
      <nav class="navbar navbar-light navbar-expand-lg p-0 pt-4 pb-4">
          <a class="navbar-brand" href="{{ url('/') }}">
              <img src="{{ asset('img/netders-logo-blue.svg') }}" width="200" />
          </a>
          <a href="#main-mmenu" class="navbar-toggler">
            <span class="navbar-toggler-icon"></span>
          </a>
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}"><img class="align-middle mb-1" src="{{ asset('img/form-search-blue.svg') }}" width="13" height="13" /> Eğitmen ara</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('netders/nasil-calisir.html') }}"><img class="align-middle mb-1" src="{{ asset('img/messaging-question-blue.svg') }}" width="13" height="13" /> Nasıl çalışır?</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('yardim') }}"><img class="align-middle mb-1" src="{{ asset('img/damage-necessities-blue.svg') }}" width="13" height="13" /> Yardım</a>
              </li>
              @if(Auth::check())
              <li class="nav-item">
                <a class="nav-link" href="{{ url('cart') }}"><img class="align-middle mb-1" src="{{ asset('img/shopping-cart-blue.svg') }}" width="13" height="13" /> Alışveriş sepeti</a>
              </li>                 
              <li class="nav-item">
                <a class="nav-link" href="{{ url('users/dashboard') }}"><img class="align-middle mb-1" src="{{ asset('img/profile-icon-blue.svg') }}" width="13" height="13" /> Hesabım</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('auth/logout') }}"><img class="align-middle mb-1" src="{{ asset('img/navigation-logout-blue.svg') }}" width="13" height="13" /> Çıkış</a>
              </li>                   
              @else
              <li class="nav-item">
                <a class="nav-link" href="{{ url('auth/login') }}"><img class="align-middle mb-1" src="{{ asset('img/navigation-login-blue.svg') }}" width="13" height="13" /> Giriş</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('auth/register') }}"><img class="align-middle mb-1" src="{{ asset('img/action-add-blue.svg') }}" width="13" height="13" /> Ücretsiz üye ol</a>
              </li>
              @endif      
            </ul>
          </div>
        </nav>
    </div>

    @yield('content')

    <div class="container">
  <div class="card bg-4 mb-4 box-shadow rounded-bottom">
    <div class="card-body">
  <footer class="pt-4 light text-center">
    <div class="p-2">Copyright © 2013 - {{ date('Y') }} {{ config('app.name', 'Netders.com') }}</div>

    <div class="d-flex flex-wrap justify-content-center">
      <div class="p-2"><a href="{{ url('/') }}">Ana Sayfa</a></div>
      <div class="p-2"><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}">Eğitmen ara</a></div>
      <div class="p-2"><a href="{{ url('netders/nasil-calisir.html') }}">Nasıl çalışır?</a></div>
      @if(Session::get('user_id'))
      <div class="p-2"><a href="{{ url('users/dashboard') }}">Hesabım</a></div>
      <div class="p-2"><a href="{{ url('auth/logout') }}">Çıkış</a></div>
      @else
      <div class="p-2"><a href="{{ url('auth/login') }}">Giriş</a></div>
      <div class="p-2"><a href="{{ url('auth/register') }}">Ücretsiz üye ol</a></div>
      @endif
      <div class="p-2"><a href="{{ url('yardim') }}">Yardım</a></div>
      <div class="p-2"><a href="{{ url('contact') }}">İletişim</a></div>
    </div>

    <div class="p-2 font-italic"><small>Netders.com internet üzerinden eğitmenler ile öğrencileri buluşturarak online eğitim imkanı sunan bir internet sitesidir. Herhangi bir kurum ile bağı yoktur.<br />Netders.com'a üye olarak <a href="{{ url('netders/kullanim-kosullari.html') }}">Kullanım koşulları</a>'nı kabul etmiş sayılırsınız.<br />{{ \Carbon\Carbon::now()->setTimezone(Session::get('timezone'))->format('d.m.Y H:i') }}</small></div>

    <div class="p-2"><img src="{{ asset('img/turkiye-white.svg') }}" width="150" /></div>

    

    <div class="d-flex justify-content-center">
      <div class="p-2"><a href="{{ url('netders/kullanim-kosullari.html') }}">Kullanım Koşulları</a></div>
      <div class="p-2"><a href="{{ url('netders/gizlilik-ilkeleri.html') }}">Gizlilik İlkeleri</a></div>
    </div>
  </footer>
</div>
</div>
</div>

<!-- Dynamic Modal -->
<div class="modal fade" id="dynamic_modal" tabindex="-1" role="dialog" aria-labelledby="dynamicModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
		</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal --> 

<nav id="main-mmenu">
      <ul>
          @foreach(\App\Models\Content::menu() as $menu)
            <li><a href="{{ $menu['url'] }}">{{ $menu['text'] }}</a></li>
          @endforeach
      </ul>
  </nav>

<script type="text/javascript">
  var base_url = '{{ url('/') }}/';
</script>

<script type="text/javascript" src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/mmenu/mmenu.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/chained/chained.remote.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/form/jquery.form.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jgrowl/jquery.jgrowl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
@if(Route::currentRouteName() == 'welcome')
<script type="text/javascript" src="{{ asset('vendor/owl/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
@endif
@if(Route::currentRouteName() == 'users/search')
<script type="text/javascript" src="{{ asset('vendor/chained/chained.remote.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/list.js') }}"></script>
@endif
@if(Route::currentRouteName() == 'users/personal' || Route::currentRouteName() == 'users/badge' || Route::currentRouteName() == 'calendar/get' || Route::currentRouteName() == 'dynamic' || Route::currentRouteName() == 'username/change' || Route::currentRouteName() == 'contents/contact')
<script type="text/javascript" src="{{ asset('vendor/mask/jquery.mask.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/intl-tel-input/build/js/intlTelInput.min.js') }}"></script>
@endif
@if(Route::currentRouteName() == 'dynamic')
<script type="text/javascript" src="{{ asset('js/detail.js') }}"></script>
@endif
<script type="text/javascript" src="{{ asset('js/general.js') }}"></script>

@if(Route::currentRouteName() == 'users/prices')
<script>get_prices();</script>
@endif

@if(Route::currentRouteName() == 'users/locations')
<script>get_locations();</script>
@endif

@if(Auth::check() && in_array(Auth::user()->group_id, [3,4,5]))
  <script src="//code.jivosite.com/widget/BilIj4yltL" async></script>
@endif

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(31356598, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        trackHash:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/31356598" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>

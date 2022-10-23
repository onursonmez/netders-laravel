@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row d-flex pb-5">
        <div class="col-lg-9 my-auto">
            <form method="GET" action="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}" id="search-form">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="text-primary font-weight-bolder mb-3">
                            Özel ders almak hiç bu kadar kolay olmamıştı!
                        </h1>
                        <p class="lead mb-4">Doğrulanmış profile sahip, alanında <strong class="font-weight-bold">uzman öğretmenlerden</strong> online veya yüz yüze özel ders alın. Hem de Netders.com güvencesiyle!</p>
                    </div>

                    <div class="col-lg-6 col-md-9 mb-3 mb-lg-0 col-7">
                        <input name="keyword" class="form-control" placeholder="Aradığınız özel ders nedir?" />
                    </div>

                    <div class="col-lg-3 col-md-3 col-5">
                        <button type="submit" class="btn btn-primary btn-block"><img class="align-middle" src="{{ asset('img/form-search-white.svg') }}" width="13" height="13" /> Öğretmen Ara</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 d-none d-lg-block">
            <img src="{{ asset('img/student.png') }}" class="img-fluid" />
        </div>

    </div>



    <div class="card mb-4 box-shadow">
      <div class="card-body">
        <h2 class="text-dark font-weight-bolder mb-4 mt-3">
          Özel ders kategorileri
        </h2>

        <p>Alanında tecrübeli eğitmenlerden özel ders alarak, ihtiyacın olan eğitime, uygun maliyetlerle ve kolayca sahip olabilirsin. <a data-toggle="collapse" href="#ctCollapse" role="button" aria-expanded="false" aria-controls="ctCollapse">Daha fazla...</a></p>

          <div class="collapse" id="ctCollapse">
          <p>Almak istediğin eğitimle ilgili aşağıdaki kategorilerden birine tıklayarak, o kategoride özel ders veren eğitmenleri görüntüleyebilirsin. Dilersen, gelişmiş arama motorunu kullanarak, tam aradığın eğitmene ulaşmanı sağlayabilirsin. Tercih ettiğin eğitmeni seçip, hakkında detaylı bilgi alabilir ve hemen iletişime geçebilirsin. Bütçe
          ve ders saatlerinin karşılıklı olarak uyuşması sonrasında özel ders almaya hemen başlayabilirsin.</p>
          </div>

        <div class="owl-6 owl-carousel owl-theme">

          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/ilkogretim-takviye">
              <img src="{{ asset('img/home-icon-ilkogretim.svg') }}" width="100%" />
            </a>
            <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/ilkogretim-takviye">İlköğretim Takviye</a></h5>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/lise-takviye">
              <img src="{{ asset('img/home-icon-lise.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/lise-takviye">Lise Takviye</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/universite-takviye">
              <img src="{{ asset('img/home-icon-universite.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/universite-takviye">Üniversite Takviye</a></h5>
            </div>
          </div>

          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/sinav-hazirlik">
              <img src="{{ asset('img/home-icon-sinavhazirlik.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/sinav-hazirlik">Sınav Hazırlık</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/yabanci-dil">
              <img src="{{ asset('img/home-icon-yabancidil.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/yabanci-dil">Yabancı Dil</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/bilgisayar">
              <img src="{{ asset('img/home-icon-bilgisayar.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/bilgisayar">Bilgisayar</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/muzik">
              <img src="{{ asset('img/home-icon-muzik.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/muzik">Müzik</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/spor">
              <img src="{{ asset('img/home-icon-spor.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/spor">Spor</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/sanat">
              <img src="{{ asset('img/home-icon-sanat.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/sanat">Sanat</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/dans">
              <img src="{{ asset('img/home-icon-dans.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/dans">Dans</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/kisisel-gelisim">
              <img src="{{ asset('img/home-icon-kisiselgelisim.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/kisisel-gelisim">Kişisel Gelişim</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/direksiyon">
              <img src="{{ asset('img/home-icon-direksiyon.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/direksiyon">Direksiyon</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/ozel-egitim">
              <img src="{{ asset('img/home-icon-ozelegitim.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/ozel-egitim">Özel Eğitim</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/oyun-ve-hobi">
              <img src="{{ asset('img/home-icon-oyunhobi.svg') }}" width="100%" />
            </a>
            <div class="caption">
              <h5><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/oyun-ve-hobi">Oyun / Hobi</a></h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if(isset($users) && !empty($users))
    @foreach($users as $title => $value)
    <div class="card mb-4 box-shadow">
      <div class="card-body">
        <h2 class="text-dark font-weight-bolder mb-4">
          {{ $title }} özel ders verenler
        </h2>
        <div class="owl-4 owl-carousel owl-theme">

          @foreach($value as $user)

					<div class="item card border mr-2 ml-2">
            <a href="{{ url($user->username) }}" target="_blank">
              <img class="card-img-top" src="{{ asset($user->photo->url ?? ($user->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')) }}">
            </a>
            <div class="card-body">
              <h5 class="card-title"><a href="{{ url($user->username) }}" target="_blank">{{ user_fullname($user->first_name, $user->last_name, $user->detail->privacy_lastname) }}</a></h5>
              <div class="mb-2"><img class="align-text-top" src="{{ asset('img/profile-bonus.svg') }}" width="16" height="16"> @if($user->prices->pluck('price_private', 'price_live')->min() != $user->prices->pluck('price_private', 'price_live')->max()){{ $user->prices->pluck('price_private', 'price_live')->min() }} - {{ $user->prices->pluck('price_private', 'price_live')->max() }}@else{{ $user->prices->pluck('price_private', 'price_live')->min() }}@endif<span> TL / Saat</span></div>
              @if($user->detail->city !== null && $user->detail->town !== null)<div class="mb-2"><img class="align-text-top" src="{{ asset('img/form-location.svg') }}" width="16" height="16"> {{ $user->detail->city->title }}, {{ $user->detail->town->title }}</div>@endif
            </div>
          </div>
					@endforeach
        </div>
      </div>
    </div>
    @endforeach
    @endif

    <div class="card box-shadow rounded-top">
      <div class="card-body mb-3">
        <h2 class="text-dark font-weight-bolder mb-4">
          Günün eğitim kategorileri
        </h2>
          @if(isset($populars) && !empty($popupars))
        @foreach ($populars->chunk(3) as $chunk)
        <div class="row">
          @foreach ($chunk as $popular)
          <div class="col-lg-4 col-md-4">
            <ul class="list-unstyled text-small mb-0">
              <li><a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug').'?keyword=' . $popular->title) }}" target="_blank">{{ $popular->title }} özel ders</a></li>
            </ul>
          </div>
          @endforeach
        </div>
        @endforeach
              @endif
      </div>
    </div>

  </div>
@endsection

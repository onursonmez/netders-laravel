@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card position-relative overflow-hidden mb-4 box-shadow">
          <div class="position-absolute bottom-0 left-0 right-0 d-none d-lg-flex flex-row-fluid">
            <span class="svg-icon svg-icon-full flex-row-fluid svg-icon-dark opacity-03">
              <img src="{{ asset('img/home-2.svg') }}" width="100%" />
            </span>
          </div>

          <div class="position-absolute d-flex top-0 left-0 col-lg-6 opacity-1 opacity-lg-100">
            <span class="svg-icon svg-icon-full flex-row-fluid p-4">
              <img src="{{ asset('img/home-1.svg') }}" width="100%" />
            </span>
          </div>

          <div class="card-body">
            <div class="row">

              <div class="col-lg-8">
                <h1 class="text-dark font-weight-bolder mb-2">
                  Özel ders
                </h1>
                <p class="lead mb-4">Alanında uzman eğitmenlerden özel ders almak ister misin? Netders.com, birebir veya canlı olarak özel ders almak isteyen öğrencileri, tam aradıkları uzman eğitmenlerle buluşturuyor.</p>
                <div class="row">
                  <div class="col-md-6">
                    <div class="media media-list mb-4">
                      <a href="#" class="width-70 height-70 radius-50 bg-light-blue p-3 text-center mr-2">
                        <img src="{{ asset('img/expression-star.svg') }}" width="100%" />
                      </a>
                      <div class="media-body">

                        <h3 class="text-dark font-weight-bolder mr-12">Pratik</h3 <p>Akıllı arama motoru ile aradığın eğitmeni kolayca bulur, istediğin zaman derse başlayabilirsin.</p>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="media media-list mb-4">
                      <a href="#" class="width-70 height-70 radius-50 bg-light-blue p-3 text-center mr-2">
                        <img src="{{ asset('img/messaging-security.svg') }}" width="100%" />
                      </a>
                      <div class="media-body">

                        <h3 class="text-dark font-weight-bolder mr-12">Güvenli</h3 <p>Tüm eğitmenlerin profilleri ayrıntılı olarak incelenir. Güvenerek eğitmenlerle görüşebilirsin.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="media media-list mb-4">
                      <a href="#" class="width-70 height-70 radius-50 bg-light-blue p-3 text-center mr-2">
                        <img src="{{ asset('img/navigation-finance-change.svg') }}" width="100%" />
                      </a>
                      <div class="media-body">

                        <h3 class="text-dark font-weight-bolder mr-12">Kesintisiz</h3 <p>7/24 eğitmenlerle iletişime geçebilir, dilediğin dersi hemen almaya başlayabilirsin.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="media media-list mb-4">
                      <a href="#" class="width-70 height-70 radius-50 bg-light-blue p-3 text-center mr-2">
                        <img src="{{ asset('img/profile-bonus.svg') }}" width="100%" />
                      </a>
                      <div class="media-body">

                        <h3 class="text-dark font-weight-bolder mr-12">Ücretsiz</h3 <p>Özel ders veren eğitmenlerin neredeyse tamamı ilk dersi ücretsiz veriyor. Bu fırsat kaçmaz.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <h2 class="text-dark font-weight-bolder mb-4">
                  Ücretsiz üye ol
                </h2>
                <form action="{{ url('auth/register') }}" method="post" class="ajax-form" autocomplete="off">
                  @csrf
                  <div class="form-group">
                    <label>Adın</label>
                    <input type="text" name="first_name" class="form-control tofirstupper" placeholder="Adın">
                  </div>
                  <div class="form-group">
                    <label>Soyadın</label>
                    <input type="text" name="last_name" class="form-control tofirstupper" placeholder="Soyadın">
                  </div>
                  <div class="form-group">
                    <label>E-posta adresin</label>
                    <input type="email" name="email" class="form-control" placeholder="E-posta adresin">
                  </div>
                  <div class="form-group">
                    <label>Şifren</label>
                    <input type="password" name="password" class="form-control" placeholder="Şifren">
                  </div>
                  <!--
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-6 col-md-6" data-name="security-code">
                        <div>
                        <img src="{{ captcha_src('math') }}" onclick="this.src='/captcha/math?'+Math.random()" id="captcha-code" class="captcha-code" width="100%" height="38" />
                        </div>
                      </div>

                      <div class="col-md-6 mt-3 mt-md-0">
                        <input type="text" name="captcha" class="form-control" placeholder="İşlemin sonucu">
                      </div>
                    </div>
                  </div>
                  -->
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="member_type" value="1">
                    <label class="form-check-label">
                      Öğrenciyim, özel ders alacağım
                    </label>
                  </div>
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="member_type" value="2">
                    <label class="form-check-label">
                      Eğitmenim, özel ders vereceğim
                    </label>
                  </div>

									<button type="submit" class="btn btn-primary js-submit-btn" onclick="document.getElementById('captcha-code').src='/captcha/math?'+Math.random()">Üye ol</button>
									<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
								</form>
              </div>
            </div>
          </div>
        </div>


    <div class="card mb-4 box-shadow">
      <div class="card-body">
        <form method="GET" action="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}" id="search-form">
          <div class="row">
            <div class="col-lg-12">
              <h2 class="text-dark font-weight-bolder mb-4">
                Sana en uygun eğitmeni bul
              </h2>
            </div>

            <div class="col-lg-5 mb-3 mb-lg-0">
              <input name="keyword" class="form-control" placeholder="Aradığın eğitim nedir?" />
            </div>

            <div class="col-lg-2">
              <button type="submit" class="btn btn-primary btn-block"><img class="align-middle" src="{{ asset('img/form-search-white.svg') }}" width="13" height="13" /> Ara</button>
            </div>
          </div>
        </form>
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
      </div>
    </div>

  </div>
@endsection

@extends('layouts.app')

@section('content')
<?
$featured_band = false;
$all_band = false;
?>
<!-- Sidebar  -->
<nav id="sidebar">
    <div id="dismiss" class="mt-2 mr-2">
        <img src="{{ asset('img/navigation-close.svg') }}" />
    </div>   
    <div class="p-4 mt-4">
        <h4 class="text-muted">Detaylı Arama</h4>
        <form method="GET" action="{{ URL::current() }}" id="search-form" class="mt-2 pb-4" autocomplete="off">
            <div class="form-group">
                <input type="text" name="keyword" class="form-control"
                    value="{{ htmlspecialchars(Request::get('keyword')) }}" data-toggle="tooltip"
                    data-placement="bottom"
                    title="Eğitmen adı arayın"
                    placeholder="Anahtar kelime..." />
            </div>
            <div class="p-2 mb-3 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/form-location.svg') }}" width="16" height="16">
                    Lokasyon</strong>
            </div>
            @if(isset($cities))
            <div class="form-group">
                <select name="city_id" data-name="city_id" id="city_id" class="form-control select2">
                    <option value="" @if(!Request::get('city_id') && !$params->city_id) selected @endif>-- {{ __('general.all') }} --</option>
                    @foreach($cities as $city)
                    <option value="{{ $city->id }}" @if(Request::get('city_id')==$city->id || $params->city_id == $city->id){{ 'selected' }}@endif>{{ $city->title }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="form-group">
                <select name="town_id" data-name="town_id" id="town_id" data-id="{{ $params->town_id }}" class="form-control select2">
                </select>
            </div>
            <div class="p-2 mb-3 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/claim-guides.svg') }}" width="16" height="16">
                    Eğitim</strong>
            </div>
            @if(isset($subjects))
            <div class="form-group">
                <select name="subject_id" data-name="subject_id" id="subject_id" class="form-control select2">
                    <option value="">-- {{ __('general.all') }} --</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" @if($subject->id == Request::get('subject') ||
                        ($params->subject_id == $subject->id)) selected @endif>{{ $subject->title }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="form-group">
                <select name="level_id" data-name="level_id" id="level_id" data-id="{{ $params->level_id }}" class="form-control select2">
                </select>
            </div>
            <div class="p-2 mb-3 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/profile-bonus.svg') }}" width="16" height="16">
                    Ücret</strong>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="text" name="price_min" class="form-control" placeholder="min TL"
                            value="@if(Request::get('price_min') > 0) {{ Request::get('price_min') }} @endif">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="text" name="price_max" class="form-control" placeholder="maks TL"
                            value="@if(Request::get('price_max') > 0) {{ Request::get('price_max') }} @endif">
                    </div>
                </div>
            </div>
            <div class="p-2 mb-2 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/damage-furniture.svg') }}" width="16" height="16">
                    Şekil</strong>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="figure[]" id="figure_1" value="1"
                    @if(Request::get('figure') && in_array(1, Request::get('figure'))) checked="checked" @endif>
                <label class="form-check-label" for="figure_1">
                    Birebir ders
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="figure[]" id="figure_2" value="2"
                    @if(Request::get('figure') && in_array(2, Request::get('figure'))) checked="checked" @endif>
                <label class="form-check-label" for="figure_2">
                    Grup dersi
                </label>
            </div>

            <div class="form-check mb-3" class="tt" data-toggle="tooltip" data-placement="top" title="Canlı dersi seçerseniz birebir ders özellikleri ve lokasyonlar devre dışı bırakılır">
                <input class="form-check-input" type="checkbox" name="live" id="live" value="1"
                    @if(Request::get('live') == 1) checked="checked" @endif />
                <label class="form-check-label" for="live">
                    Canlı ders
                </label>
            </div>            

            <div class="p-2 mb-2 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/category-town-house.svg') }}" width="16"
                        height="16"> Mekan</strong>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="place[]" id="place_1" value="1"
                    @if(Request::get('place') && in_array(1, Request::get('place'))) checked="checked" @endif>
                <label class="form-check-label" for="place_1">
                    Öğrencinin evi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="place[]" id="place_2" value="2"
                    @if(Request::get('place') && in_array(2, Request::get('place'))) checked="checked" @endif>
                <label class="form-check-label" for="place_2">
                    Eğitmen evi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="place[]" id="place_3" value="3"
                    @if(Request::get('place') && in_array(3, Request::get('place'))) checked="checked" @endif>
                <label class="form-check-label" for="place_3">
                    Etüd merkezi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="place[]" id="place_4" value="4"
                    @if(Request::get('place') && in_array(4, Request::get('place'))) checked="checked" @endif>
                <label class="form-check-label" for="place_4">
                    Kütüphane
                </label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="place[]" id="place_5" value="5"
                    @if(Request::get('place') && in_array(5, Request::get('place'))) checked="checked" @endif>
                <label class="form-check-label" for="place_5">
                    Diğer
                </label>
            </div>

            <div class="p-2 mb-2 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/category-town-house.svg') }}" width="16"
                        height="16"> Zaman</strong>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="time[]" id="time_1" value="1"
                    @if(Request::get('time') && in_array(1, Request::get('time'))) checked="checked" @endif>
                <label class="form-check-label" for="time_1">
                    Hafta içi gündüz
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="time[]" id="time_2" value="2"
                    @if(Request::get('time') && in_array(2, Request::get('time'))) checked="checked" @endif>
                <label class="form-check-label" for="time_2">
                    Hafta içi akşam
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="time[]" id="time_3" value="3"
                    @if(Request::get('time') && in_array(3, Request::get('time'))) checked="checked" @endif>
                <label class="form-check-label" for="time_3">
                    Haftasonu gündüz
                </label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="time[]" id="time_4" value="4"
                    @if(Request::get('time') && in_array(4, Request::get('time'))) checked="checked" @endif>
                <label class="form-check-label" for="time_4">
                    Haftasonu akşam
                </label>
            </div>

            <div class="p-2 mb-2 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/category-town-house.svg') }}" width="16"
                        height="16"> Hizmet</strong>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="service[]" id="service_1" value="1"
                    @if(Request::get('service') && in_array(1, Request::get('service'))) checked="checked" @endif>
                <label class="form-check-label" for="service_1">
                    Ödev Yardımı
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="service[]" id="service_2" value="2"
                    @if(Request::get('service') && in_array(2, Request::get('service'))) checked="checked" @endif>
                <label class="form-check-label" for="service_2">
                    Tez Yardımı
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="service[]" id="service_3" value="3"
                    @if(Request::get('service') && in_array(3, Request::get('service'))) checked="checked" @endif>
                <label class="form-check-label" for="service_3">
                    Proje Yardımı
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="service[]" id="service_4" value="4"
                    @if(Request::get('service') && in_array(4, Request::get('service'))) checked="checked" @endif>
                <label class="form-check-label" for="service_4">
                    Eğitim Koçluğu
                </label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="service[]" id="service_5" value="5"
                    @if(Request::get('service') && in_array(5, Request::get('service'))) checked="checked" @endif>
                <label class="form-check-label" for="service_5">
                    Yaşam Koçluğu
                </label>
            </div>

            <!--
            <div class="p-2 mb-2 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/category-town-house.svg') }}" width="16"
                        height="16"> İndirim</strong>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="d1" id="discount_1" value="1"
                    @if(Request::get('d1')) checked @endif>
                <label class="form-check-label" for="discount_1">
                    Ücretsiz İlk Ders
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="d2" id="discount_2" value="1"
                    @if(Request::get('d2')) checked @endif>
                <label class="form-check-label" for="discount_2">
                    Eğitmen Evi İndirimi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="d3" id="discount_3" value="1"
                    @if(Request::get('d3')) checked @endif>
                <label class="form-check-label" for="discount_3">
                    Grup İndirimi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="d4" id="discount_4" value="1"
                    @if(Request::get('d4')) checked @endif>
                <label class="form-check-label" for="discount_4">
                    Üye Öğrenci İndirimi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="d5" id="discount_5" value="1"
                    @if(Request::get('d5')) checked @endif>
                <label class="form-check-label" for="discount_5">
                    Paket Program İndirimi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="d6" id="discount_6" value="1"
                    @if(Request::get('d6')) checked @endif>
                <label class="form-check-label" for="discount_6">
                    Canlı Ders İndirimi
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="d7" id="discount_7" value="1"
                    @if(Request::get('d7')) checked @endif>
                <label class="form-check-label" for="discount_7">
                    Engelli İndirimi
                </label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="d8" id="discount_8" value="1"
                    @if(Request::get('d8')) checked @endif>
                <label class="form-check-label" for="discount_8">
                    Öneri İndirimi
                </label>
            </div>
            -->

            <div class="p-2 mb-2 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/category-town-house.svg') }}" width="16"
                        height="16"> Eğitmen grubu</strong>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="group[]" id="group_1" value="5"
                    @if(Request::get('group') && in_array(5, Request::get('group'))) checked @endif>
                <label class="form-check-label" for="group_1">
                    Premium
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="group[]" id="group_2" value="4"
                    @if(Request::get('group') && in_array(4, Request::get('group'))) checked @endif>
                <label class="form-check-label" for="group_2">
                    Advanced
                </label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="group[]" id="group_3" value="3"
                    @if(Request::get('group') && in_array(3, Request::get('group'))) checked @endif>
                <label class="form-check-label" for="group_3">
                    Starter
                </label>
            </div>

            <div class="p-2 mb-2 bg-light-blue">
                <strong><img class="align-text-top" src="{{ asset('img/category-town-house.svg') }}" width="16"
                        height="16"> Eğitmen cinsiyeti</strong>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="gender" id="gender_1" value="F"
                    @if(Request::get('gender')=='F' ) checked @endif>
                <label class="form-check-label" for="gender_1">
                    Kadın
                </label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="gender" id="gender_2" value="M"
                    @if(Request::get('gender')=='M' ) checked @endif>
                <label class="form-check-label" for="gender_2">
                    Erkek
                </label>
            </div>
            

            <button type="submit" class="btn btn-primary btn-block"><img class="align-middle"
                    src="{{ asset('img/form-search-white.svg') }}" width="13" height="13" /> Ara</button>
        </form>
    </div>
</nav>

<div class="container">
    <div class="card box-shadow rounded-top">
        @if(!empty($breadcrumb))
        <div class="card-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" itemscope itemtype="http://schema.org/BreadcrumbList">
                    @foreach($breadcrumb as $value)
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope
                        itemtype="http://schema.org/ListItem">
                        <a href="{{ $value['link'] }}" itemprop="item">
                            <span itemprop="name">{{ $value['title'] }}</span>
                        </a>
                    </li>
                    @endforeach
                </ol>
            </nav>
        </div>
        @endif
        <div class="card-body">

            <div class="mb-2">
                <div class="row">
                <div class="col-12 col-lg-6 pt-015 text-center text-lg-left mb-1 mb-lg-0">
                    Arama sonuçlarına uygun <strong>{{ $users->total() ?? 0 }}</strong> eğitmen bulundu.
                </div>                     
                    <div class="col-12 col-lg-6 text-center text-lg-right">
                        <a href="#" id="sidebarCollapse" class="btn btn-primary btn-sm mr-2 d-inline-block"><img
                                class="align-text-top" src="{{ asset('img/navigation-menu-white.svg') }}" width="16"
                                height="16" /> Detaylı Arama</a>
                    </div>
                </div>
            </div>

            <div class="p-3 mb-2">
            <h1 class="text-center display-5 text-dark font-weight-bolder">{{ $seo_title }}</h1>
                <div class="text-center">{{ $seo_description }}</div>
            </div>

            @if($users->total() > 0)
            @foreach($users as $user)
            @if($user->search_point >= 100 && $featured_band == false && !Request::get('sort_price') &&
            !Request::get('sort_point'))
            <div class="p-2 mb-2">
                <strong>Öne Çıkan Eğitmenler</strong>
            </div>
            <?$featured_band = true?>
            @endif

            @if(($user->search_point < 100 || Request::get('sort_price')) && $all_band==false) <div
                class="p-2 mb-2">
                <strong>Tüm Eğitmenler</strong>
        </div>
        <?$all_band = true?>
        @endif

        <div
            class="card mb-2 border border-light-blue @if($user->group_id == 5) premium @elseif($user->group_id == 4) advanced @endif ">
            <div class="card-body">
                <div class="media media-list">
                    <a href="{{ url($user->username) }}" target="_blank">
                        <img class="mr-3 photo"
                            src="{{ asset($user->photo->url ?? ($user->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')) }}"
                            alt="{{ user_fullname($user->first_name, $user->last_name, $user->detail->privacy_lastname) }}">
                    </a>
                    <div class="media-body">
                        <h4 class="mt-0">
                            <a href="{{ url($user->username) }}" target="_blank">
                            @if(Auth::user() && Auth::user()->group_id == 1){{ $user->search_point }}@endif{{ user_fullname($user->first_name, $user->last_name, $user->detail->privacy_lastname) }}</a>
                            @if(!empty($user->service_badge) && $user->service_badge->status == 'A')<img class="align-middle"
                                src="{{ asset('img/verification-badge.svg') }}" width="16" height="16"
                                data-toggle="tooltip" data-placement="top"
                                title="Bu eğitmenin alanında uzman olduğu belgelerle doğrulanmıştır"> @endif
                        </h4>
                        @if(isset($user->detail->title))<h6>{{ txtFirstUpper($user->detail->title) }}</h6> @endif

                        <div class="row mb-2">
                            <div class="col-md-3">
                                <span class="text-muted" data-toggle="tooltip" data-placement="top" title="{{Lang::get('general.lesson_price')}}">
                                    <img class="align-text-top" src="{{ asset('img/profile-bonus-gray.svg') }}" width="16"
                                        height="16">
                                    <i class="fa fa-money"></i> {{ $user->prices->pluck('price_live')->first(function ($value, $key) { return $value > 0; }) ?? $user->prices->pluck('price_private')->first(function ($value, $key) { return $value > 0; }) }} TL / Saat
                                </span>
                            </div>
                            @if($user->detail->birthday && $user->detail->privacy_age == 1)
                            <div class="col-md-3">
                                <span class="text-muted" data-toggle="tooltip" data-placement="top" title="{{Lang::get('general.age')}}">
                                    <img class="align-text-top" src="{{ asset('img/form-date-gray.svg') }}" width="16"
                                        height="16"> {{ \Carbon\Carbon::parse(str_replace('/','-',$user->detail->birthday))->age }} yaşında
                                </span>
                            </div>
                            @endif

                            @if($user->detail->city_id && $user->detail->town_id)
                            <div class="col-md-3">
                                <span class="text-muted" data-toggle="tooltip" data-placement="top" title="{{Lang::get('general.location_here')}}">
                                    <img class="align-text-top" src="{{ asset('img/form-location-gray.svg') }}" width="16"
                                        height="16"> {{ $user->detail->city->title }}, {{ $user->detail->town->title }}
                                </span>
                            </div>
                            @endif
                            <div class="col-md-3">
                                <span class="text-muted" data-toggle="tooltip" data-placement="top" title="{{Lang::get('general.last_online')}}">
                                    <img class="align-text-top" src="{{ asset('img/profile-icon-gray.svg') }}" width="16"
                                        height="16"> @if($user->online){{ Lang::get('general.online') }}@else{{ \Carbon\Carbon::parse($user->updated_at, 'UTC')->setTimezone(Session::get('timezone'))->diffForHumans() }}@endif
                                </span>
                            </div>                            
                        </div>
                        <div>
                            @if(isset($user->detail->long_text)){{ txtFirstUpper(truncate($user->detail->long_text, 200)) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif


        {{ $users->appends(request()->input())->onEachSide(1)->links() }}

    </div>
</div>
</div>
@endsection
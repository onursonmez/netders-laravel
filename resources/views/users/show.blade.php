@extends('layouts.app')

@section('content')
<div class="container">

    @if($user->status == 'C')
    <div class="card box-shadow rounded-top">
        <div class="card-body text-center" style="padding:50px 0;">
            Üzgünüz, bu hesap artık kullanılmamaktadır.
        </div>
    </div>
    @else

    @if(Session::get('last_search'))
    <div class="text-right">
        <a class="btn btn-primary btn-sm mr-2 d-inline-block mb-3" href="{{ Session::get('last_search') }}"><img
                class="align-middle" src="{{ asset('img/navigation-arrow-left-white.svg') }}" width="12" height="12" />
            Arama sonuçlarına geri dön</a>
    </div>
    @endif

    <div class="card mb-4 mb-2 box-shadow @if(!Session::get('last_search')){{'mt-3'}}@endif">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2 text-center">
                    <img class="profile-image box-shadow mb-3"
                        src="{{ asset($user->photo->url ?? ($user->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')) }}"
                        alt="{{ user_fullname($user->first_name, $user->last_name, $user->detail->privacy_lastname) }}">

                    @if(!empty($user->service_badge) && $user->service_badge->status == 'A')
                    <img class="align-middle mr-1"
                        src="{{ asset('img/verification-badge.svg') }}" width="18" height="18" data-toggle="tooltip"
                        data-placement="top" title="Bu eğitmenin alanında uzman olduğu belgelerle doğrulanmıştır">
                    @endif

                    @if($user->email_verified()->count() > 0)
                    <img class="align-middle mr-1" src="{{ asset('img/email-verified.svg') }}"
                        width="16" height="16" data-toggle="tooltip" data-placement="top"
                        title="Eğitmenin e-posta adresi doğrulanmıştır">
                    @endif

                    <img class="align-middle mr-1" src="{{ asset('img/form-date.svg') }}" width="16"
                        height="16" data-toggle="tooltip" data-placement="top"
                        title="{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }} üye oldu">

                    @if($user->online)
                    <img class="align-middle mr-1" src="{{ asset('img/profile-icon.svg') }}" width="16" height="16"
                        data-toggle="tooltip" data-placement="top" title="Çevrimiçi">
                    @else
                    <img class="align-middle mr-1" src="{{ asset('img/profile-icon-gray.svg') }}" width="16" height="16"
                        data-toggle="tooltip" data-placement="top" title="Çevrimdışı">
                    @endif
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-9">
                            <h2 class="mt-0"><a
                                    href="">{{ user_fullname($user->first_name, $user->last_name, $user->detail->privacy_lastname) }}</a>
                            </h2>
                            <div class="mb-2 font-weight-bolder">{{ $user->detail->title }}</div>
                            <div class="row mb-2 text-muted">
                                @if($user->prices->count() > 0)
                                <div class="col-lg-4"><img class="align-text-top"
                                        src="{{ asset('img/profile-bonus-gray.svg') }}" width="16" height="16">
                                        {{ $user->prices->pluck('price_live')->first(function ($value, $key) { return $value > 0; }) ?? $user->prices->pluck('price_private')->first(function ($value, $key) { return $value > 0; }) }}<span> TL / Saat</span>
                                </div>
                                @endif
                                @if($user->detail->birthday && $user->detail->privacy_age == 1)
                                <div class="col-lg-4"><img class="align-text-top"
                                        src="{{ asset('img/form-date-gray.svg') }}" width="16" height="16">
                                    {{ \Carbon\Carbon::parse(str_replace('/','-',$user->detail->birthday))->age }} yaşında</div>
                                @endif
                                @if($user->detail->city_id && $user->detail->town_id)
                                <div class="col-lg-4"><img class="align-text-top"
                                        src="{{ asset('img/form-location-gray.svg') }}" width="16" height="16">
                                    {{ $user->detail->city->title }}, {{ $user->detail->town->title }}</div>
                                @endif
                            </div>
                            <div class="mb-4 mb-lg-0">{{ $user->detail->long_text }}</div>
                        </div>
                        <div class="col-lg-3">

                            <div class="mb-3">
                                @if($user->detail->privacy_phone == 1)
                                    <a href="#" class="ajaxmobile" onclick="mobile_phone('{{ Crypt::encryptString($user->id) }}')"><img class="align-middle" src="{{ asset('img/form-tel.svg') }}" width="13" height="13" /> <span>{{ substr_replace($user->detail->phone_mobile, 'XXXXXXX', -7) }}</span></a>
                                @else
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Eğitmen telefon numarasını göstermek istemiyor"><img class="align-middle" src="{{ asset('img/form-tel.svg') }}" width="13" height="13" /> <span>{{ substr_replace($user->detail->phone_mobile, 'XXXXXXX', -7) }}</span></a>
                                @endif
                            </div>

                            <div class="mb-3">
                                @if(!Auth::check())
                                <a href="{{ url('auth/login?redirect=') . url()->current() }}" data-toggle="tooltip" data-placement="top"
                                    title="Mesaj gönderebilmek için üye girişi yapman gerekmektedir. Hesabına giriş yapmak için tıkla."><img class="align-middle" src="{{ asset('img/navigation-message.svg') }}" width="13" height="13" /> Mesaj gönder</a> 
                                @else
                                <a href="#" class="loadModal" data-url="{{ url('users/new_message') }}" data-title="Eğitmene Mesaj Gönder" data-id="{{ $user->id }}"><img class="align-middle" src="{{ asset('img/navigation-message.svg') }}" width="13" height="13" /> Mesaj gönder</a> 
                                @endif
                                <small class="text-muted d-block">Yazışma başlat</small>
                            </div>

                            <div class="mb-3">
                                @if(!Auth::check())
                                <a href="{{ url('auth/login?redirect=') . url()->current() }}" data-toggle="tooltip" data-placement="top"
                                    title="Yorum yapabilmek için üye girişi yapman gerekmektedir. Hesabına giriş yapmak için tıkla."><img class="align-middle" src="{{ asset('img/navigation-message.svg') }}" width="13" height="13" /> Mesaj gönder</a> 
                                @else
                                <a href="#" class="loadModal" data-url="{{ url('users/new_comment') }}" data-title="Eğitmene Yorum Yap" data-id="{{ $user->id }}"><img class="align-middle" src="{{ asset('img/messaging-terms.svg') }}" width="13" height="13" /> Yorum Yap</a> 
                                @endif
                                <small class="text-muted d-block">Aldığın dersi değerlendir</small>
                            </div>                            

                            <div>
                                <a href="#" class="loadModal" data-url="{{ url('users/new_complaint') }}" data-title="Profili Şikayet Et" data-id="{{ $user->id }}"><img class="align-middle"
                                        src="{{ asset('img/messaging-no-user.svg') }}" width="13" height="13" /> Şikayet et</a> <small class="text-muted d-block">İhlal bildir</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($user->prices())
    <div class="card mb-4 box-shadow">
        <div class="card-header">
            <h4 class="mb-0 pt-3 pb-3">{{ Lang::get('general.lesson_prices') }}</h4>
        </div>
        <div class="card-body">
            <table class="table table-xs">
                <thead>
                    <tr>
                        <th scope="col">{{ Lang::get('general.lesson_name') }}</th>
                        <th scope="col">{{ Lang::get('general.private_lesson') }}</th>
                        <th scope="col">{{ Lang::get('general.live_lesson') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->prices as $price)
                    <tr>
                        <td>
                            @if($price->status == 'A')
                            <a href="{{ url($price->slug) }}" target="_blank">{{ $price->subject->title }} - {{ $price->level->title }}</a>
                            @else
                            {{ $price->subject->title }} - {{ $price->level->title }}
                            @endif
                        </td>
                        <td>
                            @if(empty($price->price_private) || $price->price_private == '0.00'){{'Vermiyorum'}}@else{{ $price->price_private }} {{ 'TL / Saat' }}@endif
                        </td>
                        <td>
                            @if(empty($price->price_live) || $price->price_live == '0.00'){{'Vermiyorum'}}@else{{ $price->price_live }} {{ 'TL / Saat' }}@endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if(!empty($definition))
        @include('calendar.calendar') 
    @endif    

    <div class="card mb-4 mb-2 box-shadow">
        <div class="card-header">
            <h4 class="mb-0 pt-3 pb-3">{{ Lang::get('general.lesson_discounts') }}</h4>
        </div>    
        <div class="card-body">
            <div class="row">
                
                @foreach($discounts as $discount)
                <div class="col-lg-4">
                    @if($user->user_discounts->map->only('discount_id', 'description')->contains('discount_id', $discount->id))
                        @if($discount->id == 1)
                            <img class="align-middle" src="{{ asset('img/messaging-checked-small.svg') }}" width="14" height="14"> 
                        @else
                            <span class="badge badge-secondary">% {{ $user->user_discounts->where('discount_id', $discount->id)->pluck('rate')->first() }}</span>
                        @endif
                    @else
                        <img class="align-middle" src="{{ asset('img/navigation-close-small.svg') }}" width="14" height="14">
                    @endif
                    {{ $discount->title }}@if($user->user_discounts->map->only('discount_id', 'description')->contains('discount_id', $discount->id)) <img width="13" height="13" src="{{ asset('img/messaging-info.svg') }}" data-toggle="tooltip" data-placement="top" title="{{ $user->user_discounts->where('discount_id', $discount->id)->pluck('description')->first() ?? $discount->description }}" /> @endif
                </div>
                @endforeach

            </div>
        </div>
    </div>

    @if(!empty($user->user_figures) || !empty($user->user_places) || !empty($user->user_times) || !empty($user->user_services) || !empty($user->user_genders))
    <div class="card mb-4 box-shadow">
        <div class="card-header">
            <h4 class="mb-0 pt-3 pb-3">{{ Lang::get('general.lesson_preferences') }}</h4>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
                    <strong>{{ Lang::get('general.lesson_type') }}</strong>
                    <ul class="list-group list-group-flush">
                        @foreach($figures as $figure)
                        @if($user->user_figures->map->only('figure_id')->contains('figure_id', $figure->id))
                        <li class="list-group-item"><img class="align-middle mr-1"
                                src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $figure->title }}
                        </li>
                        @else
                        <li class="list-group-item text-muted"><img class="align-middle mr-1"
                                src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                            {{ $figure->title }}</li>
                        @endif
                        @endforeach
                    </ul>
                </div> 

                <div class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
                    <strong>{{ Lang::get('general.place') }}</strong>
                    <ul class="list-group list-group-flush">
                        @foreach($places as $place)
                        @if($user->user_places->map->only('place_id')->contains('place_id', $place->id))
                        <li class="list-group-item"><img class="align-middle mr-1"
                                src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $place->title }}
                        </li>
                        @else
                        <li class="list-group-item text-muted"><img class="align-middle mr-1"
                                src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                            {{ $place->title }}</li>
                        @endif
                        @endforeach
                    </ul>
                </div>

                <div class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
                    <strong>{{ Lang::get('general.time') }}</strong>
                    <ul class="list-group list-group-flush">
                        @foreach($times as $time)
                        @if($user->user_times->map->only('time_id')->contains('time_id', $time->id))
                        <li class="list-group-item"><img class="align-middle mr-1"
                                src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $time->title }}
                        </li>
                        @else
                        <li class="list-group-item text-muted"><img class="align-middle mr-1"
                                src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                            {{ $time->title }}</li>
                        @endif
                        @endforeach
                    </ul>
                </div> 

                <div class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
                    <strong>{{ Lang::get('general.service') }}</strong>
                    <ul class="list-group list-group-flush">
                        @foreach($services as $service)
                        @if($user->user_services->map->only('service_id')->contains('service_id', $service->id))
                        <li class="list-group-item"><img class="align-middle mr-1"
                                src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $service->title }}
                        </li>
                        @else
                        <li class="list-group-item text-muted"><img class="align-middle mr-1"
                                src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                            {{ $service->title }}</li>
                        @endif
                        @endforeach
                    </ul>
                </div> 

                <div class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
                    <strong>{{ Lang::get('general.gender') }}</strong>
                    <ul class="list-group list-group-flush">
                        @foreach($genders as $gender)
                        @if($user->user_genders->map->only('gender_id')->contains('gender_id', $gender->id))
                        <li class="list-group-item"><img class="align-middle mr-1"
                                src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $gender->title }}
                        </li>
                        @else
                        <li class="list-group-item text-muted"><img class="align-middle mr-1"
                                src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                            {{ $gender->title }}</li>
                        @endif
                        @endforeach
                    </ul>
                </div>                                                

            </div>
        </div>
    </div>
    @endif

    <div class="card mb-4 box-shadow">
        <div class="card-header">
            <h4 class="mb-0 pt-3 pb-3">{{ Lang::get('general.private_lesson_locations') }}</h4>
        </div>
        <div class="card-body">
            @if(empty($user->locations))
            {{ Lang::get('general.no_private_lesson_location_found') }}
            @else
            <div class="row">            
            @foreach($user->locations as $location)
            <div title="{{$location->city->title}}, {{$location->town->title}} Özel Ders" class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
            {{$location->city->title}}, {{$location->town->title}}
            </div>
            @endforeach
            </div>
            @endif
        </div>
    </div>    

    @if($user->detail->reference_text)
    <div class="card mb-4 box-shadow">
        <div class="card-header">
            <h4 class="mb-0 pt-3 pb-3">{{ Lang::get('general.references') }}</h4>
        </div>
        <div class="card-body">
            {{$user->detail->reference_text}}
        </div>
    </div>
    @endif

    @if($user->comments->count() > 0)
    <div class="card mt-4 box-shadow mb-4">
        <div class="card-header">
            <h4 class="mb-0 pt-3 pb-3">{{ Lang::get('general.comments') }}</h4>
        </div>
        <div class="card-body">
            @foreach($user->comments as $key => $comment)
            
            <p class="text-muted"><img class="align-top mt-1" src="{{ asset('img/profile-icon-gray.svg') }}" width="14"
                    height="14"> {{ $comment->user->first_name }} <img class="ml-3 align-top mt-1"
                    src="{{ asset('img/form-date-gray.svg') }}" width="14" height="14"> {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
            </p>
            <p>
                @if($comment->rating)
                @for($i=0;$i<$comment->rating;$i++)
                <img class="align-middle mr-1" src="{{ asset('img/expression-star.svg') }}" width="13" height="13" />
                @endfor
                @endif
            </p>
            <p>{{ $comment->comment }}</p>
            @if($key+1 != sizeof($user->comments))
            <hr />
            @endif
            @endforeach
        </div>
    </div>
    @endif





</div>
<!--/.container-->

@endif

</div>

@endsection
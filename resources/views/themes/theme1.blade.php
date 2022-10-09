<!doctype html>
<html lang="en">

<head>

    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--====== Title ======-->
    <title>{{ $seo_title }}</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('theme1/images/favicon.png') }}" type="image/png">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('theme1/css/bootstrap.min.css') }}">

    <!--====== Line Icons css ======-->
    <link rel="stylesheet" href="{{ asset('theme1/css/LineIcons.css') }}">

    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="{{ asset('theme1/css/magnific-popup.css') }}">

    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{ asset('theme1/css/default.css') }}">

    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{ asset('theme1/css/style.css') }}">

    <!--====== Common css ======-->
    <link rel="stylesheet" href="{{ asset('vendor/jgrowl/jquery.jgrowl.min.css') }}">

</head>

<body>

    <!--====== PRELOADER PART START ======-->

    <div class="preloader">
        <div class="loader_34">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== PRELOADER ENDS START ======-->

    <!--====== HEADER PART START ======-->

    <header id="home" class="header-area">
        <div class="navigation fixed-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                {{ user_fullname($user->first_name, $user->last_name, $user->detail->privacy_lastname) }}
                            </a> <!-- Logo -->
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item active"><a class="page-scroll" href="#home">ANA SAYFA</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="#about">HAKKIMDA</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="#service">İNDİRİMLER</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="#work">DERSLER</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="#comment">YORUMLAR</a></li>
                                    <li class="nav-item"><a class="page-scroll" href="#contact">İLETİŞİM</a></li>
                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- navigation -->

        <div id="parallax" class="header-content d-flex align-items-center">
            <div class="header-shape shape-one layer" data-depth="0.10">
                <img src="{{ asset('theme1/images/banner/shape/shape-1.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="header-shape shape-tow layer" data-depth="0.30">
                <img src="{{ asset('theme1/images/banner/shape/shape-2.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="header-shape shape-three layer" data-depth="0.40">
                <img src="{{ asset('theme1/images/banner/shape/shape-3.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="header-shape shape-fore layer" data-depth="0.60">
                <img src="{{ asset('theme1/images/banner/shape/shape-2.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="header-shape shape-five layer" data-depth="0.20">
                <img src="{{ asset('theme1/images/banner/shape/shape-1.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="header-shape shape-six layer" data-depth="0.15">
                <img src="{{ asset('theme1/images/banner/shape/shape-4.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="header-shape shape-seven layer" data-depth="0.50">
                <img src="{{ asset('theme1/images/banner/shape/shape-5.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="header-shape shape-eight layer" data-depth="0.40">
                <img src="{{ asset('theme1/images/banner/shape/shape-3.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="header-shape shape-nine layer" data-depth="0.20">
                <img src="{{ asset('theme1/images/banner/shape/shape-6.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="header-shape shape-ten layer" data-depth="0.30">
                <img src="{{ asset('theme1/images/banner/shape/shape-3.png') }}" alt="Shape">
            </div> <!-- header shape -->
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-5 col-lg-6">
                        <div class="header-content-right">
                            <h4 class="sub-title">Merhaba, ben</h4>
                            <h1 class="title">{{ user_fullname($user->first_name, $user->last_name, $user->detail->privacy_lastname) }}</h1>
                            <p>{{ $user->detail->title }}</p>
                            <a class="main-btn" href="#about">Hakkımda</a>
                        </div> <!-- header content right -->
                    </div>
                    <div class="col-lg-6 offset-xl-1">
                        <div class="header-image d-none d-lg-block">
                            <img src="{{ asset($user->photo->url ?? ($user->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')) }}" alt="hero">
                        </div> <!-- header image -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
            
        </div> <!-- header content -->
    </header>

    <!--====== HEADER PART ENDS ======-->

    <!--====== ABOUT PART START ======-->

    <section id="about" class="about-area pt-125 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Hakkımda</h2>
                        <p>{{ $user->detail->long_text }}</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-content mt-50">
                        <ul class="clearfix">
                            @if($user->prices->count() > 0)
                            <li>
                                <div class="single-info text-center">
                                    <div class="info-icon">
                                        <i class="lni-wallet"></i>
                                    </div>
                                    <div class="info-text">
                                        <p><span>Ders Ücreti:</span> @if($user->prices->pluck('price_private', 'price_live')->min() != $user->prices->pluck('price_private', 'price_live')->max()){{ $user->prices->pluck('price_private', 'price_live')->min() }} - {{ $user->prices->pluck('price_private', 'price_live')->max() }}@else{{ $user->prices->pluck('price_private', 'price_live')->min() }}@endif TL / Saat</p>
                                    </div>
                                </div> <!-- single info -->
                            </li>
                            @endif
                            @if($user->detail->city_id && $user->detail->town_id)
                            <li>
                                <div class="single-info text-center">
                                    <div class="info-icon">
                                        <i class="lni-map-marker"></i>
                                    </div>
                                    <div class="info-text">
                                        <p><span>Yer:</span> {{ $user->detail->city->title }}, {{ $user->detail->town->title }}</p>
                                    </div>
                                </div> <!-- single info -->
                            </li>   
                            @endif                         
                        </ul>
                    </div> <!-- about content -->
                </div>
            </div> <!-- row -->            
        </div> <!-- container -->
    </section>

    <!--====== ABOUT PART ENDS ======-->

    <!--====== SERVICES PART START ======-->

    <section id="service" class="services-area gray-bg pt-125 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center pb-30">
                        <h2 class="title">Özel Ders İndirimleri</h2>
                        <p>Özel ders almadan önce aşağıdaki indirimleri inceleyip, size uygun olan indirimi seçebilirsiniz.</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                @foreach($discounts as $discount)
                @if($discount->id != 2)
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="single-service text-center mt-30">
                        <div class="service-icon">
                            @if($discount->id == 1)
                            <i class="lni-gift"></i>
                            @elseif($discount->id == 3)
                            <i class="lni-layers"></i>
                            @elseif($discount->id == 4)
                            <i class="lni-heart"></i>
                            @elseif($discount->id == 5)
                            <i class="lni-users"></i>
                            @elseif($discount->id == 6)
                            <i class="lni-users"></i> 
                            @endif                                                    
                        </div>
                        <div class="service-content">
                            <h4 class="service-title"><a href="#">@if($discount->id != 1){{ '%' }} {{ $user->user_discounts->where('discount_id', $discount->id)->pluck('rate')->first() }}@endif {{ $discount->title }}</a></h4>
                            <p>{{ $user->user_discounts->where('discount_id', $discount->id)->pluck('description')->first() ?? $discount->description }}</p>
                        </div>
                    </div> <!-- single service -->
                </div>
                @endif
                @endforeach        
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== SERVICES PART ENDS ======-->

    <!--====== CALL TO ACTION PART START ======-->

    <section id="call-to-action" class="call-to-action pt-125 pb-130 bg_cover" style="background-image: url({{ asset('theme1/images/call-to-action.jpg') }})">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9">
                    <div class="call-action-content text-center">
                        <h2 class="action-title">Özel derse mi ihtiyacın var?</h2>
                        <p>Etkili öğrenme metodları ile kalıcı bir şekilde istediğin eğitimleri benden alabilirsin.</p>
                        <ul>
                            <li><a class="main-btn custom" href="#contact">İLETİŞİM</a></li>
                        </ul>
                    </div> <!-- call action content -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== CALL TO ACTION PART ENDS ======-->

    <!--====== WORK PART START ======-->

    <section id="work" class="work-area pt-125 pb-130">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center pb-25">
                        <h2 class="title">Dersler</h2>
                        <p>Verdiğim dersler ve ücretleri.</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row">
                <div class="col-lg-12">
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
                                    {{ $price->subject->title }} - {{ $price->level->title }}
                                </td>
                                <td>
                                    @if(empty($price->price_private) || $price->price_private == '0.00'){{'Vermiyorum'}}@else{{ $price->price_private }} {{ 'TL' }}@endif
                                </td>
                                <td>
                                    @if(empty($price->price_live) || $price->price_live == '0.00'){{'Vermiyorum'}}@else{{ $price->price_live }} {{ 'TL' }}@endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>                    
                </div>
            </div> <!-- row -->

            @if(!empty($definition))
            <div class="row">
                <div class="col-lg-12">
                    <div class="work-more text-center mt-50">
                        <a class="main-btn" href="{{ env('APP_URL') . '/' . $user->username }}">CANLI DERS SATIN AL</a>
                    </div> <!-- work more -->
                </div>
            </div> <!-- row -->
            @endif
        </div> <!-- container -->
    </section>

    <!--====== WORK PART ENDS ======-->

    <section class="pricing-area gray-bg pt-125 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center pb-25">
                        <h2 class="title">Ders verilen lokasyonlar</h2>
                        <p>Birebir ders verdiğim lokasyonlar.</p>
                    </div> <!-- section title -->
                </div>
                <div class="col-lg-12">
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
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <section class="figures-area white-bg pt-125 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section-title text-center pb-25">
                        <h2 class="title">Ders verilen şekiller</h2>
                        <p>Birebir ders verdiğim şekiller.</p>
                    </div> <!-- section title -->
                </div>

                <div class="col-lg-4 col-md-8 col-sm-9">
                <div class="single-pricing text-center mt-30">
                    <div class="pricing-package">
                        <h4 class="package-title">{{ Lang::get('general.lesson_type') }}</h4>
                    </div>
                    <div class="pricing-body">
                        <div class="pricing-text">
                            <p>Ders verdiğim türler.</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                            @foreach($figures as $figure)
                            @if($user->user_figures->map->only('figure_id')->contains('figure_id', $figure->id))
                            <li><img class="align-middle mr-1"
                                    src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $figure->title }}
                            </li>
                            @else
                            <li class="text-muted"><img class="align-middle mr-1"
                                    src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                                {{ $figure->title }}</li>
                            @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                </div>

                <div class="col-lg-4 col-md-8 col-sm-9">
                <div class="single-pricing text-center mt-30">
                    <div class="pricing-package">
                        <h4 class="package-title">{{ Lang::get('general.gender') }}</h4>
                    </div>
                    <div class="pricing-body">
                        <div class="pricing-text">
                            <p>Ders verdiğim cinsiyetler.</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                            @foreach($genders as $gender)
                            @if($user->user_genders->map->only('gender_id')->contains('gender_id', $gender->id))
                            <li><img class="align-middle mr-1"
                                    src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $gender->title }}
                            </li>
                            @else
                            <li class="text-muted"><img class="align-middle mr-1"
                                    src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                                {{ $gender->title }}</li>
                            @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div> 
                </div>    

                <div class="col-lg-4 col-md-8 col-sm-9">
                <div class="single-pricing text-center mt-30">
                    <div class="pricing-package">
                        <h4 class="package-title">{{ Lang::get('general.time') }}</h4>
                    </div>
                    <div class="pricing-body">
                        <div class="pricing-text">
                            <p>Ders verdiğim zamanlar.</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                            @foreach($times as $time)
                            @if($user->user_times->map->only('time_id')->contains('time_id', $time->id))
                            <li><img class="align-middle mr-1"
                                    src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $time->title }}
                            </li>
                            @else
                            <li class="text-muted"><img class="align-middle mr-1"
                                    src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                                {{ $time->title }}</li>
                            @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>  
                </div>    
                
                <div class="col-lg-4 col-md-8 col-sm-9">
                <div class="single-pricing text-center mt-30">
                    <div class="pricing-package">
                        <h4 class="package-title">{{ Lang::get('general.service') }}</h4>
                    </div>
                    <div class="pricing-body">
                        <div class="pricing-text">
                            <p>Ders verdiğim servisler.</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                            @foreach($services as $service)
                            @if($user->user_services->map->only('service_id')->contains('service_id', $service->id))
                            <li><img class="align-middle mr-1"
                                    src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $service->title }}
                            </li>
                            @else
                            <li class="text-muted"><img class="align-middle mr-1"
                                    src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                                {{ $service->title }}</li>
                            @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>                      
                </div>                                 

                <div class="col-lg-4 col-md-8 col-sm-9">
                <div class="single-pricing text-center mt-30">
                    <div class="pricing-package">
                        <h4 class="package-title">{{ Lang::get('general.place') }}</h4>
                    </div>
                    <div class="pricing-body">
                        <div class="pricing-text">
                            <p>Ders verdiğim yerler.</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                            @foreach($places as $place)
                            @if($user->user_places->map->only('place_id')->contains('place_id', $place->id))
                            <li><img class="align-middle mr-1"
                                    src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> {{ $place->title }}
                            </li>
                            @else
                            <li class="text-muted"><img class="align-middle mr-1"
                                    src="{{ asset('img/navigation-close-small-gray.svg') }}" width="13" height="13" />
                                {{ $place->title }}</li>
                            @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>    
                </div>   

            </div> <!-- row -->
        </div> <!-- container -->
    </section>    

    <!--====== COMMENT PART START ======-->

    <section id="comment" class="services-area gray-bg pt-125 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center pb-25">
                        <h2 class="title">Yorumlar</h2>
                        <p>Öğrencilerim tarafından yapılan yorumlar.</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            @if($user->comments->count() > 0)
            @foreach($user->comments as $key => $comment)
            
            <p class="text-muted"><img class="align-top mt-1" src="{{ asset('img/profile-icon-gray.svg') }}" width="14"
                    height="14"> {{ substr($comment->user->first_name, 0, 1) }}. {{ substr($comment->user->last_name, 0, 1) }}. <img class="ml-3 align-top mt-1"
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
            @else            
            <p class="text-center">{{ 'Henüz yorum bulunmamaktadır.' }}</p>
            @endif
            
        </div> <!-- container -->
    </section>

    <!--====== COMMENT PART ENDS ======-->

    <!--====== CONTACT PART START ======-->

    <section id="contact" class="contact-area white-bg pt-125 pb-130 gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center pb-25">
                        <h2 class="title">İletişim</h2>
                        <p>
                            Benimle iletişime geçin.
                        </p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6 col-sm-7">
                    <div class="contact-box text-center mt-30">
                        <div class="contact-icon">
                            <i class="lni-map-marker"></i>
                        </div>
                        <div class="contact-content">
                            <h6 class="contact-title">Yer</h6>
                            <p>
                            @if($user->detail->city_id && $user->detail->town_id)
                            {{ $user->detail->city->title }}, {{ $user->detail->town->title }}
                            @endif                                   
                            </p>
                        </div>
                    </div> <!-- contact box -->
                </div>

                @if($user->detail->privacy_phone == 1)
                <div class="col-lg-6 col-md-6 col-sm-7">
                    <div class="contact-box text-center mt-30">
                        <div class="contact-icon">
                            <i class="lni-phone"></i>
                        </div>
                        <div class="contact-content">
                            <h6 class="contact-title">Telefon</h6>
                            <a href="javascript:void(0);" class="ajaxmobile" onclick="mobile_phone('{{ Crypt::encryptString($user->id) }}')"><img class="align-middle" src="{{ asset('img/form-tel.svg') }}" width="13" height="13" /> <span>{{ substr_replace($user->detail->phone_mobile, 'XXXXXXX', -7) }}</span></a>
                        </div>
                    </div> <!-- contact box -->
                </div>
                @endif

            </div> <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-form pt-30">
                        <form method="post" action="{{ asset('send_message') }}" class="ajax-form">
                            @csrf
                            <div class="single-form">
                                <input type="text" name="full_name" placeholder="Ad Soyad">
                            </div> <!-- single form -->
                            <div class="single-form">
                                <input type="email" name="email" placeholder="E-posta">
                            </div> <!-- single form -->
                            <div class="single-form">
                                <input type="text" name="phone_mobile" placeholder="Cep telefonu">
                            </div> <!-- single form -->                            
                            <div class="single-form">
                                <textarea name="message" placeholder="Mesaj"></textarea>
                            </div> <!-- single form -->
                            <p class="form-message"></p>
                            <div class="single-form">
                                <button class="main-btn js-submit-btn" type="submit">Gönder</button>
                                <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                            </div> <!-- single form -->
                        </form>
                    </div> <!-- contact form -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== CONTACT PART ENDS ======-->

    <!--====== FOOTER PART START ======-->

    <footer id="footer" class="footer-area">
        
        <div class="footer-copyright pb-20">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright-text text-center pt-20">
                            <p>Copyright © {{ date('Y') }}. Tüm hakları saklıdır.</p>
                        </div> <!-- copyright text -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer widget -->
    </footer>

    <!--====== FOOTER PART ENDS ======-->

    <a href="#" class="back-to-top"><i class="lni-chevron-up"></i></a>

    <script type="text/javascript">
        var base_url = '{{ url('/') }}/';
    </script>

    <!--====== jquery js ======-->
    <script src="{{ asset('theme1/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('theme1/js/vendor/jquery-1.12.4.min.js') }}"></script>

    <!--====== Bootstrap js ======-->
    <script src="{{ asset('theme1/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme1/js/popper.min.js') }}"></script>

    <!--====== Magnific Popup js ======-->
    <script src="{{ asset('theme1/js/jquery.magnific-popup.min.js') }}"></script>

    <!--====== Parallax js ======-->
    <script src="{{ asset('theme1/js/parallax.min.js') }}"></script>

    <!--====== Counter Up js ======-->
    <script src="{{ asset('theme1/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('theme1/js/jquery.counterup.min.js') }}"></script>

    <!--====== Appear js ======-->
    <script src="{{ asset('theme1/js/jquery.appear.min.js') }}"></script>

    <!--====== Scrolling js ======-->
    <script src="{{ asset('theme1/js/scrolling-nav.js') }}"></script>
    <script src="{{ asset('theme1/js/jquery.easing.min.js') }}"></script>

    <!--====== Main js ======-->
    <script src="{{ asset('theme1/js/main.js') }}"></script>

    <!--====== Common js ======-->
    <script src="{{ asset('vendor/chat/vendor/sweetalert2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/form/jquery.form.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jgrowl/jquery.jgrowl.min.js') }}"></script>
    <script src="{{ asset('theme1/js/general.js') }}"></script>
    
</body>

</html>

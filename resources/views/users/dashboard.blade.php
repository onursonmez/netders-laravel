@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            @include('utilities.alerts') 
            @include('utilities.my_notifications')
            @if(Auth::user()->is_teacher())
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">{{ Auth::user()->first_name}}, Hoşgeldin</h4>
                </div>
                <div class="card-body">
                    Profilini ziyaret eden kişilerin aylık bazda son bir yılı içeren grafiği aşağıdadır. *

                    <canvas id="visitorChart" height="100"></canvas>
                    <p><small>* Grafik her gün otomatik olarak yenilenir. Bu nedenle son 24 saatte ait verileri kapsamaz.<br />* Eski tüm profil ziyaret verileri sıfırlanmıştır. 01.03.2021 tarihinden sonraki veriler gösterilir.</small></p>
                </div>
            </div>
            @endif

            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Beğen, Fırsatları Kaçırma!</h4>
                </div>
                <div class="card-body">
                    <p>{{ config('app.name', 'Netders.com') }} Facebook sayfasını beğenen eğitmenlerimize öncelikli fırsatlar sunuyoruz. Bu fırsatları belirli aralıklarla hesabına ait e-posta adresine gönderiyoruz. Facebook sayfamızı beğenerek bu fırsatlardan sen de yararlanabilirsin.</p>

                    <div id="fb-root"></div>
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/tr_TR/sdk.js#xfbml=1&version=v9.0&appId=151079864961005&autoLogAppEvents=1" nonce="VUTijPXw"></script>
                    <div class="fb-like" data-href="https://www.facebook.com/netderscom" data-width="" data-layout="standard" data-action="like" data-size="large" data-share="false"></div>
                </div>
            </div>            

            @if(Auth::user()->is_teacher())
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Satın Alabileceğin Hizmetler</h4>
                </div>
                <div class="card-body">

                    <div class="media media-list">
                        <a href="#">
                            <img src="{{ asset('img/dikkat-ceken-egitmenler.png') }}" width="100%" class="mr-3 photo" />
                        </a>					
                        <div class="media-body">
                            <form method="post" action="{{ url('cart/add') }}" class="ajax-form">
                                @csrf
                                <h4 class="media-heading">Öne Çıkanlar</h4>

                                <div class="mt-2 mb-2">
                                    <h5>
                                        <span class="badge badge-secondary">
                                        {{ $product[9]['price'] }} TL
                                        </span>
                                    </h5>
                                </div>

                                <p>Öne Çıkanlar hizmeti alarak bir hafta boyunca arama sonuçlarında öncelikli olan "Öne Çıkan Eğitmenler" arasında Premium ve Advanced üyelerden sonra yer alırsın. Arama sonuçlarında öğrenciler öncelikli olarak senin profilini görür ve daha fazla öğrenciye özel ders verme imkanına sahip olursun.</p>
                                <p class="text-muted">Öne Çıkanlar hizmetinin süresi 1 haftadır.</p>
                                
                                <button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
                                <button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>

                                <input type="hidden" name="product_id" value="9" />
                            </form>
                        </div>
                    </div>

                    @if(empty(Auth::user()->service_badge))
                    <hr />

                    <div class="media media-list">
                        <a href="#">
                            <img src="{{ asset('img/uzman-egitmen-rozeti.png') }}" width="100%" class="mr-3 photo" />
                        </a>					
                        <div class="media-body">
                            <form method="post" action="{{ url('cart/add') }}" class="ajax-form">
                                @csrf
                                <h4 class="media-heading">Uzman Eğitmen Rozeti</h4>

                                <div class="mt-2 mb-2">
                                    <h5>
                                        <span class="badge badge-secondary">
                                            {{ $product[10]['price'] }} TL
                                        </span>
                                    </h5>
                                </div>

                                <p>Uzman eğitmen rozeti alan eğitmenler aramalarda ayrıcalıklandırılır. Arama sonuçlarında ve profil detay sayfalarında "Uzman Eğitmen Rozeti" bulunur ve açıklamasında "Eğitmenin uzmanlığı belgelerle doğrulanmıştır" bilgisi yer alır. Ayrıca profili arama sonuçlarında Uzman Eğitmen Rozeti olmayan ve ücretli yükseltme hizmeti almamış tüm eğitmenlerin üstünde çıkar.</p>
                                <p class="text-muted">Uzman eğitmen rozeti bir defa satın alınır ve ömür boyu kullanılır.</p>
                                
                                <button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
                                <button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>

                                <input type="hidden" name="product_id" value="10" />
                            </form>
                        </div>
                    </div>
                    @endif

                    @if(!Auth::user()->domain())
                    <hr />

                    <div class="media media-list">
                        <a href="#">
                            <img src="{{ asset('img/profesyonel-alan-adi.png') }}" width="100%" class="mr-3 photo" />
                        </a>					
                        <div class="media-body">
                            <form method="post" action="{{ url('cart/add') }}" class="ajax-form">
                                @csrf
                                <h4 class="media-heading">Profesyonel Alan Adı</h4>

                                <div class="mt-2 mb-2">
                                    <h5>
                                        <span class="badge badge-secondary">
                                            {{ $product[11]['price'] }} TL
                                        </span>
                                    </h5>
                                </div>

                                <p>Profesyonel Alan Adı hizmeti ile yalnızca sana ait olan bir alan adı (domain) ve bu alan adına ait istediğin e-posta adresine sahip olursun. Alan adı (domain) ve e-posta adresini kayıt edilmemiş olması şartıyla dilediğin gibi seçebilirsin. Profil sayfan seçtiğin alan adında çalışır ve yalnızca sana ait olan bilgiler yer alır.</p>
                                <p class="text-muted">Profesyonel Alan Adı hizmetinin süresi 1 yıldır.</p>

                                <button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
                                <button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                                
                                <input type="hidden" name="product_id" value="11" />
                            </form>
                        </div>
                    </div>
                    @endif
                    
                    <hr />

                    <div class="media media-list">
                        <a href="#">
                            <img src="{{ asset('img/profil-reklami.png') }}" width="100%" class="mr-3 photo" />
                        </a>					
                        <div class="media-body">
                            <form method="post" action="{{ url('cart/add') }}" class="ajax-form">
                                @csrf
                                <h4 class="media-heading">Profil Reklamı</h4>
                                
                                <div class="mt-2 mb-2">
                                    <h5>
                                        <span class="badge badge-secondary">
                                            {{ $product[13]['price'] }} TL
                                        </span>
                                    </h5>
                                </div>

                                <p>Profil reklam hizmeti alarak, ders verdiğin konularda ve lokasyonlarda uygun öğrencilerin doğrudan profiline yönlendirilmesi sağlanır. Paketin kullanımı tamamlandığında, e-posta adresine raporu gönderilir.</p>
                                <p class="text-muted">Her hizmet için derslerinle ilgilenen <u>en az</u> 150 farklı öğrenci ziyareti garanti edilir.</p>

                                <button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
                                <button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>

                                <input type="hidden" name="product_id" value="13" />
                            </form>                            
                        </div>
                    </div>
                    
                    <!--

                    <hr />

                    <div class="media media-list">
                        <a href="#">
                            <img src="{{ asset('img/ana-sayfa-vitrini.png') }}" width="100%" class="mr-3 photo" />
                        </a>					
                        <div class="media-body">
                            <form method="post" action="{{ url('cart/add') }}" class="ajax-form">
                                @csrf
                                <h4 class="media-heading">Ana Sayfa Vitrini</h4>

                                <div class="mt-2 mb-2">
                                    <h5>
                                        <span class="badge badge-secondary">
                                            {{ $product[12]['price'] }} TL
                                        </span>
                                    </h5>
                                </div>

                                <p>Ana Sayfa Vitrini hizmeti alarak, {{ config('app.name', 'Netders.com') }} ana sayfasında 1 hafta boyunca profilin yer alır. Siteye giriş yapan kişiler öncelikli olarak senin profilini görür. Daha fazla öğrenci edinmek, akılda kalıcı olmak, isim yapmak veya bir marka oluşturmak isteyen eğitmenler için önerilir.</p>
                                <p class="text-muted">Ana Sayfa Vitrini hizmetinin süresi 1 haftadır.</p>
                                
                                
                                <button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
                                <button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>

                                <input type="hidden" name="product_id" value="12" />
                            </form>                                  
                        </div>
                    </div>
                    -->
                    
                </div>
            </div>     
            @endif

            	            
            @if(Auth::user()->is_teacher())
            <div class="card box-shadow mb-4">
            <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Geçebileceğin Üyelikler</h4>
                </div>
                <div class="card-body">

                    @if(Auth::user()->group_id == 3 || Auth::user()->group_id == 4 || Auth::user()->group_id == 5)
                    <div class="media media-list">
                        <a href="#">
                            <img src="{{ asset('img/amblem-premium.png') }}" width="100%" class="mr-3 photo" />
                        </a>					
                        <div class="media-body">
                            <form method="post" action="{{ url('cart/add') }}" class="ajax-form">
                                @csrf
                                <h4 class="media-heading">Premium Üyelik</h4>

                                <ul class="list-group list-group-flush text-left">
                                <li class="list-group-item"><img class="align-middle mr-1" src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> Arama sonuçlarında en üst kısımda, starter ve advanced üyelerin üstünde yer alırsın</li>
                                <li class="list-group-item"><img class="align-middle mr-1" src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> Profil çerçeven mavi çizgili, kalın ve çok dikkat çekici görünür</li>
                                <li class="list-group-item"><img class="align-middle mr-1" src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> Telefon numaranı üye olmayan öğrencilere açabilirsin</li>       
                                <li class="list-group-item"><img class="align-middle mr-1" src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> Profil sayfanda benzer üyeler yer almaz</li>
                                </ul>

                                <div class="row">
                                    <div class="col-md-4 col-12 mt-2 mb-2">
                                        <select name="product_id" class="form-control select2">
                                            <option value="5">{{ $product[5]['price'] }} TL / 1 Ay</option>
                                            <option value="6">{{ $product[6]['price'] }} TL / 3 Ay</option>
                                            <option value="7">{{ $product[7]['price'] }} TL / 6 Ay</option>
                                            <option value="8">{{ $product[8]['price'] }} TL / 1 Yıl</option>
                                        </select>              
                                    </div>
                                    <div class="col-md-8 col-12 mt-2 mb-2">
                                        <button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
                                        <button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                                    </div>
                                </form>    
                            </div>              
                            
                        </div>
                    </div>

                    @endif

                    @if(Auth::user()->group_id == 3 || Auth::user()->group_id == 4)

                    <hr />
                    
                    <div class="media media-list">
                        <a href="#">
                            <img src="{{ asset('img/amblem-advanced.png') }}" width="100%" class="mr-3 photo" />
                        </a>					
                        <div class="media-body">
                            <form method="post" action="{{ url('cart/add') }}" class="ajax-form">
                                <h4 class="media-heading">Advanced Üyelik</h4>

                                <ul class="list-group list-group-flush text-left">
                                    <li class="list-group-item"><img class="align-middle mr-1" src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> Arama sonuçlarında premium üyelerden sonra, starter üyelerden önce yer alırsın</li>
                                    <li class="list-group-item"><img class="align-middle mr-1" src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> Arama sonuçlarında profil çerçeven starter üyelerden daha kalın çizgi ile dikkat çeker</li>
                                    <li class="list-group-item"><img class="align-middle mr-1" src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> Telefon numaranı üye olmayan öğrencilere açabilirsin</li>       
                                    <li class="list-group-item"><img class="align-middle mr-1" src="{{ asset('img/messaging-checked-small.svg') }}" width="13" height="13" /> Profil sayfanda benzer üyeler yer almaz</li>
                                </ul>
                                
                                <div class="row">
                                    <div class="col-md-4 col-12 mt-2 mb-2">
                                        <select name="product_id" class="form-control select2">
                                            <option value="1">{{ $product[1]['price'] }} TL / 1 Ay</option>
                                            <option value="2">{{ $product[2]['price'] }} TL / 3 Ay</option>
                                            <option value="3">{{ $product[3]['price'] }} TL / 6 Ay</option>
                                            <option value="4">{{ $product[4]['price'] }} TL / 1 Yıl</option>
                                        </select>                         
                                    </div>
                                    <div class="col-md-8 col-12 mt-2 mb-2">
                                        <button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
                                        <button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                                    </div>
                                </div>   
                            </form>    
                        </div>
                    </div>        
                    @endif            

                </div>
            </div>    
            @endif 
                           

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
var ctx = document.getElementById('visitorChart').getContext('2d');
var visitorChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["<?=implode('","', array_keys($views))?>"],
        datasets: [{
            label: 'Ziyaret',
            data: [{{ implode(',', array_values($views)) }}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
@endsection
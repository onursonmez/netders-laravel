@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card mt-4 box-shadow rounded-top">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <h3>Adres</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Ali Rıza Gürcan Cad. Eski Çırpıcı Yolu Sok. Merter Meridyen İş Merkezi No: 1 Kat: 6 No: 241/D<br />Merter / İstanbul</li>
                        <li class="list-group-item">+ 90 212 248 88 88</li>
                        <li class="list-group-item"><a href="#"><img src="{{ asset('img/ndm.png') }}" width="120" height="11" /></a></li>
                    </ul>
                    <hr>
                    <h3>Fırsatları kaçırmayın</h3>
                    <p>
                        Netders.com ile ilgili güncel fırsat ve duyurulardan haberdar olmak için bizi takip edin.
                    </p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="http://fb.com/netderscom" target="_blank"><i class="fa fa-facebook fa-fw"></i> fb.com/netderscom</a></li>
                        <li class="list-group-item"><a href="http://twitter.com/netderscom" target="_blank"><i class="fa fa-twitter fa-fw"></i> twitter.com/netderscom</a></li>
                        <li class="list-group-item"><a href="http://instagram.com/netderscom" target="_blank"><i class="fa fa-instagram fa-fw"></i> instagram.com/netderscom</a></li>
                    </ul>
                </div>
                <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3>Online İletişim</h3>
                                </div>
                            </div>
                            <div id="message-contact"></div>
                            <form action="{{ url('contact') }}" method="post" class="ajax-form">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="text-muted">Ad</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Adınız">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="text-muted">Soyad</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Soyadınız">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="text-muted">E-posta</label>
                                    <input type="email" name="email" class="form-control" placeholder="E-posta adresiniz">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="text-muted">Telefon</label>
                                    <input type="text" name="intl-mobile" class="form-control" data-type="mobile-number" />
                                </div>
                                <div class="form-group col-12">
                                    <label class="text-muted">Mesaj</label>
                                    <textarea name="message" rows="5"  class="form-control" placeholder="Mesajınız"></textarea>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-6" data-name="security-code">
                                    <div>
                                    <img src="{{ captcha_src('math') }}" onclick="this.src='/captcha/math?'+Math.random()" id="captcha-code" class="captcha-code" width="100%" height="38" />
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3 mt-md-0">
                                    <input type="text" name="captcha" class="form-control" placeholder="İşlemin sonucu">
                                </div>
                                
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary js-submit-btn">Gönder</button>
                                    <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                                </div>
                            </div>
                        </form>
                </div>

                <div class="col-lg-12 mt-4">
                    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=cP0vu1SatRTPIqmm1U-bPL4xokGVTP8P&amp;width=100%&amp;height=500&amp;lang=tr_TR&amp;sourceType=constructor&amp;scroll=true"></script>

                            <form action="http://maps.google.com/maps" method="get" target="_blank">
                            <div class="row  mt-4">
                                <div class="col-lg-10">
                                    <input type="text" name="saddr" placeholder="Yola çıkacağınız adresi yazınız" class="form-control medium-input" />
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-primary btn-block" type="submit" value="Yol tarifi al">Yol Tarifi Al</button>
                                </div>
                            </div>
                            <input type="hidden" name="daddr" value="Merter Meridyen İş Merkezi Güngören / İstanbul"/>
                            </form>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
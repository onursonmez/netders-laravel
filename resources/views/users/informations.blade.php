@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
            <form  action="{{ url('users/informations') }}" method="post" class="ajax-form js-dont-reset">
                @csrf
                <div class="card box-shadow mb-4">
                    <div class="card-header">
                        <h4 class="mb-0 pt-3 pb-3">Tanıtım Yazıları</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">

                            <div class="form-group col-12">
                                <h3 class="margin-bottom-5">Başlık</h3>
                                <p>Arama sonuçlarında ve profil detay sayfanda isminin hemen altında yazacak, kendin veya verdiğin eğitimle alakalı tek cümleden oluşan vurucu yazı veya bir slogan.</p>
                                <input name="title" data-type="count" data-length="45" class="form-control" value="{{ old('title') ?? Auth::user()->detail->title }}" maxlength="45" placeholder="Örnekler; Matematik mühendisinden özel ders, Boğaziçiliden özel ders, Araç kullanmak kabus değil vb." />
                                <small id="title_count">45 karakter kaldı</small>
                            </div>
                            <div class="form-group col-12">
                                <hr />
                            </div>
                            <!--
                            <div class="form-group col-12">
                                <h3 class="margin-bottom-5">Karşılama Metni</h3>
                                <p>Karşılama yazısı, öğrencilerin arama sonuçlarında sizinle ilgili gördüğü ilk kısa bilgidir. Aslında bu alanı <u>detaylı tanıtım metni</u> ile <u>ders yaklaşımı ve tecrübesi</u> alanlarının bir özeti olarak düşünebilirsiniz.</p>
                                <textarea name="text_short" data-type="count" data-length="500" class="form-control" rows="4" maxlength="500" placeholder="Örneğin; Alanında 15 yıllık tecrübeye sahip olmuş uzman direksiyon eğitmeninden, yalnızca bir hafta içerisinde İstanbul trafiğinde araç kullanma garantisi ile özel direksiyon dersi. Hemen arayın, size özel indirim fırsatlarını kaçırmayın.">{{ old('text_short') ?? Auth::user()->detail->text_short }}</textarea>
                                <span class="lightgrey-text font-size-11" id="text_short_count">500 karakter kaldı</span>
                            </div>
                            -->
                            <div class="form-group col-12">
                                <h3 class="margin-bottom-5">Detaylı Tanıtım Metni</h3>
                                <p>Kendinden ve eğitiminden detaylı olarak bahsedeceğin alandır. Lütfen bu alana kendinle alakalı tüm bilgileri girmeyi unutma. Herkes eğitmen ararken çok titizdir ve ayrıntılara çok dikkat eder. Bu alanı yazdığın yazılar öğrencinin seni seçmesinde büyük rol oynayacak.</p>
                                <textarea name="long_text" data-type="count" data-length="1000" class="form-control" rows="4" maxlength="1000" placeholder="Bu alana; aldığınız eğitim ile ilgili ayrıntılar, dereceleriniz, sertifikalarınız, katıldığınız kurs ve seminerler, iş hayatınız, sosyal hayatınız gibi bilgileri harmanlayarak sizinle ilgili detaylı bir tanıtım metni çıkartabilirsiniz. Lütfen fazla bilgi vermekten çekinmeyin. Kendinizle ilgili ne kadar fazla bilgi verirseniz öğrenciler o kadar çok güven duyarlar.">{{ old('long_text') ?? Auth::user()->detail->long_text }}</textarea>
                                <small id="long_text_count">1000 karakter kaldı</small>
                            </div>
                            <div class="form-group col-12">
                                <hr />
                            </div>                            
                            <!--
                            <div class="form-group col-12">
                                <h3 class="margin-bottom-5">Ders Yaklaşımı ve Tecrübesi</h3>
                                <p>Bu alana, sizin derslerinizin diğer derslerden farkını, uyguladığınız özel teknikleri, ne kadar süredir kaç kişiye ders verdiğinizi ve başarı oranlarınızı içeren, öğrencilerin sizi seçmesini sağlayacak herşeyi yazınız.</p>
                                <textarea name="text_lesson" data-type="count" data-length="1000" class="form-control" rows="4" maxlength="1000" placeholder="Örneğin; Kişiye öze uyguladığım tekniklerle öğrencilerin 1 yılda öğrendiği konuları 2 ayda öğretiyorum. Uyguladığım görsel, işitsel ve eğlenceli eğitim modeli ile ilköğretimden üniversiteye tüm öğrencilerime başarıyla sonuçlanan özel dersler verdim. Uyguladığım eğitim tekniği ile 5 yıldır yaklaşık 1000 öğrenciden %100 başarı oranına sahibim. İstenildiği taktide özel ders verdiğim öğrencilerimle sizi görüştürebilirim.">{{ old('text_lesson') ?? Auth::user()->detail->text_lesson }}</textarea>
                                <span class="lightgrey-text font-size-11" id="text_lesson_count">1000 karakter kaldı</span>
                            </div>
                            -->
                            <div class="form-group col-12">
                                <h3 class="margin-bottom-5">Referanslar</h3>
                                <p>Daha önce çalıştığın kamu kurumları veya özel sektörler, bireysel veya grup olarak ders verdiğin kitleler gibi sana referans olacak kişi ve kurumu her biri tek satır olacak şekilde yaz. Sakın e-posta veya telefon numarası gibi özel bir bilgi paylaşma 😊</p>
                                <textarea name="reference_text" data-type="count" data-length="1000" class="form-control" rows="4" maxlength="1000">{{ old('reference_text') ?? Auth::user()->detail->reference_text }}</textarea>
                                <small id="reference_text_count">1000 karakter kaldı</small>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
                                <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                            </div>
                        </div>

                </div>
            </div>

            </form>

            <!-- Modal Expert Terms -->
            <div class="modal fade" id="informations-txt" tabindex="-1" role="dialog" aria-labelledby="informationsLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tanıtım Yazısı Ekleme Kuralları</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! content(24) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Anlaşıldı!</button>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
		</div>
	</div>
</div>
@endsection

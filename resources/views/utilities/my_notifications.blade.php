@if(isset($live_lesson) && !empty($live_lesson))
<div class="alert alert-info box-shadow">
    <p>Yaklaşan canlı dersiniz {{ \Carbon\Carbon::parse($live_lesson->start_at, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('d.m.Y H:i')}} tarihinde başlayacak. Dersten 15 dakika önce giriş butonu aktif olacak.</p>
    <!--<a class="btn btn-primary" href="{{ $live_lesson->student_link }}">Derse gir</a>-->
</div>
@endif

@if(Auth::user()->status == 'A' && Auth::user()->email_verified()->count() == 0)
<form method="post" action="{{ url('activation/resend') }}" class="ajax-form">
    @csrf
    <div class="alert alert-warning box-shadow">
        <p>😳 E-posta adresin <strong>{{ Auth::user()->email }}</strong> henüz doğrulanmadı. Posta kutunun istenmeyen/spam klasörlerini kontrol etmeyi unutma. On dakika ara ile tekrar doğrulama e-postası gönderebilirsin. E-posta adresini yanlış girdiysen <a href="{{ url('email/change') }}">buraya</a> tıklayarak değiştirebilirsin. Herşey doğru ancak e-posta gelmediyse bizimle iletişime geçebilirsin.</p>
        <button type="submit" class="btn btn-primary js-submit-btn">E-posta adresimi doğrula</button>
        <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
    </div>
</form>
@endif

@if(Auth::user()->status == 'R' && !empty(Auth::user()->required()))
<div class="alert alert-warning box-shadow">
    <p>😳 Profilin arama sonuçlarında görünmüyor.</p>
    <a class="btn btn-primary" href="{{ url('users/required') }}">Nedenini öğrenmek için buraya tıkla</a>
</div>
@endif

@if(Auth::user()->status == 'R' && empty(Auth::user()->required()))
<div class="alert alert-info box-shadow">
    <p>👌 Profilin tamamsa arama sonuçlarında çıkman için incelemeye göndermen gerekiyor.</p>
    <a class="btn btn-primary" href="{{ url('users/review') }}" class="js-click-on-loading">Profilimi incelemeye gönder</a>
</div>
@endif

@if(Auth::user()->status == 'S')
<div class="alert alert-info box-shadow">
    ⌛ Profilin incelenme aşamasındadır. İncelenme tamamlandıktan sonra e-posta ile bilgilendirileceksin.
</div>
@endif

@if(Auth::user()->status == 'A' && Auth::user()->is_teacher() && teacher_profile_missing(Auth::user()->id)->prices == false && Route::currentRouteName() != 'prices_text')
<div class="alert alert-warning box-shadow">
    <p>📝 Verdiğin dersler için tanıtım yazısı yazmadın.</p>
    <a class="btn btn-primary" href="{{ url('prices') }}">Ders tanıtımı için buraya tıkla</a>
</div>
@endif

@if(!empty(Auth::user()->service_badge) && Auth::user()->service_badge->status == 'W')
<div class="alert alert-warning box-shadow">
    <p>Uzman eğitmen rozeti için belge bekleniyor.</p>
    <a class="btn btn-primary" href="{{ url('upload/badge') }}">Belge yükle</a>
</div>
@endif

@if(!empty(Auth::user()->service_badge) && Auth::user()->service_badge->status == 'P')
<div class="alert alert-info box-shadow">
    ⌛ Yüklediğin uzmanlık belgen inceleme bekliyor. İncelenme tamamlandıktan sonra e-posta ile bilgilendirileceksin.
</div>
@endif

@if(Auth::user()->domain('W'))
<div class="alert alert-warning box-shadow">
    <p>😳 Profesyonel alan adını belirlemedin.</p>
    <a class="btn btn-primary" href="{{ url('domain') }}">Belirle</a>
</div>
@endif

@if(Auth::user()->domain('P'))
<div class="alert alert-info box-shadow">
    ⌛ Profesyonel alan adı kayıt işlemi sürüyor. Tamamlandığında e-posta ile bilgilendirileceksin.
</div>
@endif

@if(Auth::user()->ad('P'))
<div class="alert alert-info box-shadow">
    ⌛ Profiline reklam hizmeti devam ediyor. Tamamlandığında e-posta ile bilgilendirileceksin.
</div>
@endif
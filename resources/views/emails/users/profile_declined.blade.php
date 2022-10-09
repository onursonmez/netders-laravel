@component('mail::message')
# {{ $user->first_name }},

Üzgünüm, profilin editörlerimiz tarafından incelenmiş ancak onaylanamamıştır. Lütfen profil bilgilerini tekrar gözden geçir.

@if($message)
Editörün mesajı: {{ $message }}

İlgili düzenlemeleri yaptıktan sonra tekrar incelemeye göndermeni dört gözle bekliyoruz.
@endif

@component('mail::button', ['url' => url('auth/login')])
Hesabım
@endcomponent

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
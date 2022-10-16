@component('mail::message')
# {{ $user->first_name }},

Tebrikler! Profilin editörlerimiz tarafından incelenerek onaylanmıştır.

@component('mail::button', ['url' => url('auth/login')])
Hesabım
@endcomponent

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
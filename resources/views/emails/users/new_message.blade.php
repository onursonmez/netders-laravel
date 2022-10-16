@component('mail::message')
# {{ $user->first_name }},

{{ config('app.name') }} üzerinden yeni bir mesaj aldın. Hesabına giriş yaparak mesajı görüntüleyebilirsin.

@component('mail::button', ['url' => url('chat')])
Mesajlarıma git
@endcomponent

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
@component('mail::message')
# {{ $user->first_name }},

Profesyonel alan adından yeni mesaj gönderildi. Mesaj bilgileri aşağıdadır.

Ad Soyad: {{ $message['full_name'] }}<br />
E-posta: {{ $message['email'] }}<br />
Telefon: {{ $message['phone_mobile'] }}<br />
Mesaj: {{ $message['message'] }}<br />

İyi çalışmalar,<br>
{{ config('app.name') }}
@endcomponent
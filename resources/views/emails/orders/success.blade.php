@component('mail::message')
# {{ $user->first_name }},

Siparişin başarıyla tamamlanmıştır 😞

Kredi kartınla ilgili bir problem olmuş olabilir. Kredi kartından herhangi bir ücret çekilmedi. Lütfen kontrol edip tekrar dene.


Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
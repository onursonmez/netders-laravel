@component('mail::message')
# {{ $email_request->user->first_name }},

{{ config('app.name') }} üzerinde yeni bir e-posta adresi tanımladın.

Hesabının güvenliği için e-posta adresini doğrulamamız gerekiyor. Aşağıda yer alan e-posta adresimi doğrula butonuna tıklayarak bu işlemi tamamlayabilirsin.

@component('mail::button', ['url' => url('auth/activation?email='.$email_request->user->email.'&token='.$email_request->token)])
E-posta adresimi doğrula
@endcomponent

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
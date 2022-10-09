@component('mail::message')
# {{ $password_request->user->first_name }},

Hesabının şifresini değiştirmek için bir talep oluşturdun. Şifreni değiştirmek için aşağıdaki şifremi değiştir butonuna tıklaman gerekiyor.

Talebi sen yapmadıysan bu e-postayı silebilirsin.

@component('mail::button', ['url' => url('auth/forgot_process?email='.$password_request->email.'&token='.$password_request->token)])
Şifremi değiştir
@endcomponent

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
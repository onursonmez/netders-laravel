@extends('layouts.app')

@section('content')
<div class="container">

<div class="card mt-4 box-shadow rounded-top">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Şifremi Unuttum</h4>
	</div>
	<div class="card-body">
        @include('utilities.alerts')

		<p>Şifreni unuttuysan, kayıtlı e-posta adresin ve istediğin yeni şifreyi aşağıdaki alanlara girerek şifre değiştirme talebinde bulunabilirsin.</p>

		<form  action="{{ url('auth/forgot') }}" method="post" class="ajax-form">
            @csrf
			<div class="row">
				<div class="form-group col-12 col-lg-3">
					<label class="text-muted">E-posta</label>
					<input type="text" name="email" class="form-control" placeholder="E-posta adresin" value="{{ old('email') }}">
				</div>   
				<div class="form-group col-12 col-lg-3">
					<label class="text-muted">Matematik işlemi</label>
					<div>
						<img src="{{ captcha_src('math') }}" onclick="this.src='/captcha/math?'+Math.random()" id="captcha-code" class="captcha-code" width="100%" height="38" />
					</div>
				</div>
				<div class="form-group col-12 col-lg-3">
					<label class="text-muted">İşlemin sonucunu gir</label>
					<input type="text" name="captcha" class="form-control" placeholder="İşlemin sonucu">
				</div>	
				<div class="col-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Şifremi değiştir</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>
			</div>
		</form>

		<hr />

		<a href="{{ url('auth/login') }}">&raquo; Şifremi hatırladım, giriş yapmak istiyorum</a>
		<br />
		<a href="{{ url('auth/register') }}">&raquo; Üye değilim, ücretsiz üye olmak istiyorum</a>
	</div>
</div>

</div>
@endsection
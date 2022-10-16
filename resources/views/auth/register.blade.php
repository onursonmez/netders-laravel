@extends('layouts.app')

@section('content')
<div class="container">

<div class="container">

<div class="card mt-4 box-shadow">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Ücretsiz üye ol</h4>
	</div>
	<div class="card-body">

		@include('utilities.alerts')  

		<p>👋 Merhaba, aşağıdaki küçük formu doldurarak aramıza katılabilirsin.</p>

		<form  action="{{ url('auth/register') }}" method="post" class="ajax-form">
			@csrf
			<div class="row">
				<div class="form-group col-12 col-lg-6">
					<label class="text-muted">Ad</label>
					<input type="text" name="first_name" class="form-control tofirstupper" placeholder="Adın" value="{{old('first_name')}}" />
				</div>
				<div class="form-group col-12 col-lg-6">
					<label class="text-muted">Soyad</label>
					<input type="text" name="last_name" class="form-control tofirstupper" placeholder="Soyadın" value="{{old('last_name')}}" />
				</div>
				<div class="form-group col-12 col-lg-6">
					<label class="text-muted">E-posta</label>
					<input type="email" name="email" class="form-control" placeholder="E-posta adresin" value="{{old('email')}}" />
				</div>
				<div class="form-group col-12 col-lg-6">
					<label class="text-muted">Şifre</label>
					<input type="password" name="password" class="form-control" placeholder="Şifren" />
				</div>
				<div class="form-group col-12">
					<input type="radio" name="member_type" value="1" id="mt3" @if(old('member_type') == 1) checked @endif /> <label for="mt3">Öğrenciyim, özel ders alacağım</label><br />
					<input type="radio" name="member_type" value="2" id="mt4" @if(old('member_type') == 2) checked @endif /> <label for="mt4">Eğitmenim, özel ders vereceğim</label><br />
				</div>
				
				<div class="form-group col-12 col-lg-2">
					<label class="text-muted">Matematik işlemi</label>
					<div>
						<img src="{{ captcha_src('math') }}" onclick="this.src='/captcha/math?'+Math.random()" id="captcha-code" class="captcha-code" width="100%" height="38" />
					</div>
				</div>
				<div class="form-group col-12 col-lg-2">
					<label class="text-muted">İşlemin sonucunu gir</label>
					<input type="text" name="captcha" class="form-control" placeholder="İşlemin sonucu">
				</div>		
				
				<div class="col-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Üye ol</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>

			</div>
		</form>

        <hr />
        
        <p>Hesabın varsa aşağıdaki bağlantıları kullanabilirsin:</p>

		<a href="{{ url('auth/forgot') }}"><i class="fa fa-link"></i>&raquo; Şifremi unuttum</a>
		<br />
		<a href="{{ url('auth/login') }}"><i class="fa fa-link"></i>&raquo; Üyeyim, giriş yapmak istiyorum</a>
	</div>
</div>


</div>

@endsection
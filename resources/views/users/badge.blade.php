@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
			@include('utilities.alerts') 
			<form  action="{{ url('upload/badge') }}" method="post" class="ajax-form" enctype="multipart/form-data">
				@csrf
				<div class="card box-shadow mb-4">
					<div class="card-header">
						<h4 class="mb-0 pt-3 pb-3">Uzmanlık Belgesi</h4>
					</div>
					<div class="card-body">
						<p>Aşağıdaki dosya yükleme alanına uzmanlığını doğrulayacak herhangi bir belge yüklemelisin. Yüklediğin belge incelenerek sonucu e-posta adresine gönderilecektir.</p>
						<div class="row">

							@if(Auth::user()->is_teacher())
							<div class="form-group col-12">
								<label>Belge</label>
								<input type="file" name="document" class="filestyle" data-text="Belge Seç">
								<small class="mt-2 d-block">
									<span class="float-right">150x150 piksel (jpg, png, pdf)</span>
								</small>
							</div>
							@endif

							<div class="col-12">
								<button type="submit" class="btn btn-primary js-submit-btn">Yükle</button>
								<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
							</div>

						</div>
					</div>
				</div>



			</form>		
		</div>
	</div>
</div>
@endsection
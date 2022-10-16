@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
			@include('utilities.alerts') 
			<form  action="{{ url('users/personal') }}" method="post" class="ajax-form js-dont-reset" enctype="multipart/form-data">
				@csrf
				<div class="card box-shadow mb-4">
					<div class="card-header">
						<h4 class="mb-0 pt-3 pb-3">Kişisel Bilgiler</h4>
					</div>
					<div class="card-body">
								<div class="row">
									<div class="form-group col-12 col-lg-6">
										<label>Adın</label>
										<input type="text" name="first_name" class="form-control tofirstupper" value="{{ Auth::user()->first_name }}" />
									</div>

									<div class="form-group col-12 col-lg-6">
										<label>Soyadın</label>
										<input type="text" name="last_name" class="form-control tofirstupper" value="{{ Auth::user()->last_name }}" data-toggle="tooltip" data-placement="top" title="Lütfen soyadınızı doğru giriniz. Soyadı alanına hoca, öğretmen vb. yazmayınız. Soyadınızın görünmesini istemiyorsanız tercihler bölümünden gizleyebilirsiniz." />
									</div>

									<div class="form-group col-12 col-lg-6">
										<label>Doğum Tarihin</label>
										<input type="text" name="birthday" class="form-control date" value="{{ Auth::user()->detail->birthday }}" />
									</div>

									<div class="form-group col-12 col-lg-6">
										<label>Cinsiyetin</label>
										<select name="gender" class="form-control select2">
											<option value="">-- Lütfen Seçiniz --</option>
											<option value="F" @if(Auth::user()->detail->gender == 'F') selected @endif>Kadın</option>
											<option value="M" @if(Auth::user()->detail->gender == 'M') selected @endif>Erkek</option>
										</select>
									</div>

									<div class="form-group col-12 col-lg-6">
										<label>Cep Telefonu Numaran</label><br />
										<input type="text" name="intl-mobile" class="form-control" data-type="mobile-number" value="{{ Auth::user()->detail->phone_mobile }}" @if(Auth::user()->is_teacher()) data-toggle="tooltip" data-placement="top" title="Telefon numaranın profil sayfanda görünmesini istemiyorsan tercihler bölümünden gizleyebilirsin" @endif />
										@if(Auth::user()->is_teacher())<small>Gizliliğin hakkında <a target="_blank" href="{{ url('yardim/kisisel-bilgilerimin-gizliligini-nasil-saglarim.html') }}">detaylı bilgi</a> al</small>@endif
									</div>

									@if($professions ?? '')
									<div class="form-group col-12 col-lg-6">
										<label>Mesleğin</label>
										<select name="profession_id" class="form-control select2">
											<option value="">-- Lütfen Seçiniz --</option>
											@foreach($professions as $profession)
											<option value="{{ $profession->id }}" @if(old('profession_id') == $profession->id || Auth::user()->detail->profession_id == $profession->id) selected @endif><?=$profession->title?></option>
											@endforeach
										</select>
									</div>
									@endif

									@if(Auth::user()->is_teacher())
									<div class="form-group col-12">
										<label>Profil Fotoğrafın</label>
										<input type="file" name="photo" class="filestyle" data-buttonText="Fotoğraf Seç">
										<small class="mt-2 d-block">
											@if(Auth::user()->pending_photos()->count() > 0)
												<span class="float-left">Yüklediğin fotoğraf onay bekliyor</span>
											@elseif(Auth::user()->photo)
											<span class="float-left">Onaylı fotoğraf</span> <a href="{{ url(Auth::user()->photo->url ?? '') }}" target="_blank" class="ml-2">Göster</a> <a href="{{ url('users/delete_photo?id=' . Auth::user()->photo->id) }}" class="ml-2">Sil</a>
											@endif
											<span class="float-right">150x150 piksel (jpg, png)</span>
										</small>
									</div>
									@endif

									<div class="form-group col-12">
										<label>Adresin</label><br />
										<input type="text" name="address" class="form-control" value="{{ Auth::user()->detail->address }}" />
									</div>

									@if($cities ?? '')
									<div class="form-group col-12 col-lg-6">
										<label>Bulunduğun Şehir</label>
										<select name="city_id" id="city_id" data-name="city_id" class="form-control select2">
											<option value="">-- Lütfen Seçiniz --</option>
											@foreach($cities as $city)
											<option value="<?=$city->id?>"@if(old('city_id') == $city->id || Auth::user()->detail->city_id == $city->id){{'selected'}}@endif>{{ $city->title }}</option>
											@endforeach
										</select>
									</div>
									@endif

									<div class="form-group col-12 col-lg-6">
										<label>Bulunduğun İlçe</label>
										<select name="town_id" id="town_id" data-name="town_id" data-id="{{ old('town_id') ?? Auth::user()->detail->town_id }}" class="form-control select2"></select>
									</div>

									<div class="form-group col-12 col-lg-6">
										<label>Saat Dilimin</label>
										<select name="timezone_id" class="form-control select2">
											<option value="">-- Lütfen Seçiniz --</option>
											@foreach($timezones as $timezone)
											<option value="{{ $timezone->id }}" @if(old('timezone_id') == $timezone->id || Auth::user()->timezone_id == $timezone->id || $timezone->id == 16) selected @endif><?=$timezone->title?></option>
											@endforeach
										</select>
									</div>									

									<div class="col-12">
										<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
										<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
									</div>

								</div>
					</div>
				</div>


				@if(Auth::user()->is_teacher())
				<div class="card box-shadow mb-4">
					<div class="card-header">
						<h4 class="mb-0 pt-3 pb-3">Firma Bilgilerin</h4>
					</div>
					<div class="card-body">
						<p>Firma olarak özel ders hizmetleri sunuyorsan firmanın ismini girebilirsin. Böylece profilinde adın ve soyadın yerine firma adı yazar. Fotoğraf yerine firmanın logosunu (yalnızca eğitimle alakalı ise) yükleyebilirsin.</p>
						<div class="row">
							<div class="form-group col-12">
								<label>Firma Adı</label>
								<input type="text" name="company_title" class="form-control" value="{{ Auth::user()->detail->company_title }}" />
							</div>

							<div class="col-12">
								<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
								<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
							</div>

						</div>
					</div>
				</div>
				@endif

			</form>		
		</div>
	</div>
</div>
@endsection
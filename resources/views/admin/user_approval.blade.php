@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
			<form  action="{{ url('cp/user_approval') }}" method="post">
				@csrf
				<div class="card box-shadow mb-4">
					<div class="card-header">
						<h4 class="mb-0 pt-3 pb-3">Kişisel Bilgiler</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group col-12 col-lg-6">
								<label>Ad</label>
								<input type="text" name="first_name" class="form-control tofirstupper" value="{{ $user->first_name }}" />
							</div>

							<div class="form-group col-12 col-lg-6">
								<label>Soyad</label>
								<input type="text" name="last_name" class="form-control tofirstupper" value="{{ $user->last_name }}" />
							</div>

							<div class="form-group col-12">
								<label>Başlık</label>
                                <input name="title" data-type="count" data-length="45" class="form-control" value="{{ $user->detail->title }}" maxlength="45" />
                                <small id="title_count">45 karakter kaldı</small>
                            </div>

							<div class="form-group col-12">
								<label>Detaylı Tanıtım Metni</label>
                                <textarea name="long_text" data-type="count" data-length="1000" class="form-control" rows="8" maxlength="1000">{{ $user->detail->long_text }}</textarea>
                                <small id="long_text_count">1000 karakter kaldı</small>
                            </div>

							<div class="form-group col-12">
								<label>Referanslar</label>
                                <textarea name="reference_text" data-type="count" data-length="1000" class="form-control" rows="8" maxlength="1000">{{ $user->detail->reference_text }}</textarea>
                                <small id="reference_text_count">1000 karakter kaldı</small>
                            </div>

							@if($user->photo)
							<div class="form-group col-12">
								<img src="{{ asset($user->photo->url) }}" />
                            </div>		
							@endif

							<div class="col-12">
								<button type="submit" class="btn btn-primary">Onayla</button>
                            </div>
						</div>
					</div>
				</div>
				<input type="hidden" name="id" value="{{ $user->id }}" />
			</form>	
		</div>

		<div class="col-lg-12">
			<form  action="{{ url('cp/user_decline') }}" method="post">
				@csrf
				<div class="card box-shadow mb-4">
					<div class="card-header">
						<h4 class="mb-0 pt-3 pb-3">Reddet</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group col-12">
								<label>Açıklama</label>
                                <textarea name="message" class="form-control" rows="4"></textarea>
                            </div>


							<div class="col-12">
								<button type="submit" class="btn btn-danger">Reddet</button>
                            </div>
						</div>
					</div>
				</div>
				<input type="hidden" name="id" value="{{ $user->id }}" />
			</form>	
		</div>		
	</div>
</div>
@endsection
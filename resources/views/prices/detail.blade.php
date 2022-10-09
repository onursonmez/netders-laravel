@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card mt-4 box-shadow rounded-top">
		<div class="card-header">
			<h1>{{ $price->title }}</h1>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-lg-8">
					<p>{{ $price->description }}</p>
					<hr />
					<p><strong>Kategori:</strong> {{ $price->subject->title }}</p>
					<p><strong>Birebir Ders Ücreti:</strong> {{ $price->price_private }} TL</p>
					<p><strong>Canlı Ders Ücreti:</strong> @if(empty($price->price_live)){{ 'Verilmiyor' }}@else{{ $price->price_live }} TL @endif</p>
					<p>{{ $price->level->title }} özel dersi veren eğitmenin profiline gitmek için <a href="{{ url($price->user->username) }}">buraya</a> tıklayınız. {{ $price->level->title }} özel dersi veren eğitmenleri görüntülemek için <a href="{{ url('ozel-ders-ilanlari-verenler/'.Session::get('city_slug')) }}/{{ $price->level->slug }}">buraya</a> tıklayınız.</p>
				</div>
				<div class="col-12 col-lg-4 text-center">
					<div><img class="mb-2" width="200" src="{{ asset($price->user->photo->url ?? ($price->user->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')) }}" /></div>

					<div><strong>{{ user_fullname($price->user->first_name, $price->user->last_name, $price->user->detail->privacy_lastname) }}</strong></div>

					<div class="mb-2">
						@if($price->user->online)
							<span><i class="fa fa-power-off"></i> Çevrimiçi</span>
						@else
							<span class="text-muted">Çevrimdışı</span>
						@endif
					</div>

					<a class="btn btn-primary" href="{{ url($price->user->username) }}">Profili Görüntüle</a>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
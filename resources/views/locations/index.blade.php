@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Yeni Ders Verilen Bölge</h4>
                </div>
                <div class="card-body">
                    <p>Ders verdiğin bölgeleri tanımlamak için önce şehir sonra görünür duruma gelen ilçeleri seçip, ekle butonuna bas.</p>
                    <form  action="{{ url('locations/store') }}" method="post" class="ajax-form js-dont-reset">
                        <div class="row">

                            <div class="form-group col-12">
                                <label>Şehir</label>
                                <select name="city_id" data-load-from="selectbox" data-load-url="{{ url('locations/load_new') }}" data-load-to="load_new" class="form-control">
                                    <option value="">-- Lütfen Seçin --</option>
                                    @foreach($cities as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <small>İlçeler şehir seçiminden sonra görünür duruma gelir.</small>
                            </div>

                        </div>

                        <div class="row" id="load_new"></div>
						<input type="hidden" name="call" value="load('{{ url('locations/load_exists/' . Auth::user()->id) }}', 'load')" />
                    </form>
                </div>
            </div>

            <div id="load">
                @include('locations.load_exists', $locations)
            </div>
        </div>
	</div>
</div>
@endsection
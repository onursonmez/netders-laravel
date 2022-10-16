@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Yeni Ders Ücreti</h4>
                </div>
                <div class="card-body">
                    <p>Ders ücreti tanımlamak için aşağıdan önce konu seç ve açılan derslerden derslerini seçerek ücretlerini de gir ve ekle tuşuna bas lütfen.</p>
                    <p>Birden fazla aynı ücretteki dersleri seçerek tek seferde girişini yapabilirsin. Ders ücreti farklı olan derslerin ücret tanımlamasını ayrı ayrı yapman gerekiyor. Ders ücreti tanımlaman tamamlandığında, dilediğin zaman aşağıda yer alan tanımlı ders ücretlerim alanından ders ücretlerini güncelleyebilirsin.</p>
                    <form  action="{{ url('prices/store') }}" method="post" class="ajax-form js-dont-reset">
                        <div class="row">

                            <div class="form-group col-12">
                                <label>Konu</label>
                                <select name="subject_id" data-load-from="selectbox" data-load-url="{{ url('prices/load_new') }}" data-load-to="load_new" class="form-control">
                                    <option value="">-- Lütfen Seçin --</option>
                                    @foreach($subjects as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Dersler ve ücret tanımlama alanları konu seçiminden sonra görünür duruma gelir.</small>
                            </div>

                        </div>

                        <div class="row" id="load_new"></div>
						<input type="hidden" name="call" value="load('{{ url('prices/load_exists/' . Auth::user()->id) }}', 'load')" />
                    </form>
                </div>
            </div>

            <form action="{{ url('prices/update') }}" method="POST" class="ajax-form js-dont-reset">
                <div id="load">
					@include('prices.load_exists', $prices)
				</div>
            </form>
        </div>
	</div>
</div>
@endsection
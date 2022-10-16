@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            <form  action="{{ url('users/discounts') }}" method="post" class="ajax-form js-dont-reset">
                @csrf
                <div class="card box-shadow mb-4">
                    <div class="card-header">
                        <h4 class="mb-0 pt-3 pb-3">Birebir Ders İndirimleri</h4>
                    </div>
                    <div class="card-body">
                        <p>Öğrencilerinize çeşitli durumlarda indirim fırsatları sunabilirsiniz. Aşağıdaki alanda yer alan durumlardan, istediğiniz oranlarda indirim oranı belirleyebilirsiniz.</p>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <table class="table table-borderless">
                                    <tbody>
                                        @foreach($discounts as $key => $discount)
                                        <tr>
                                            <td>
                                                <strong>{{ $discount->title }}</strong> @if(in_array($discount->id, [1,2]))<img src="{{ asset('img/messaging-info.svg') }}" width="16" height="16" data-toggle="tooltip" data-placement="top" title="Bu indirimi verirsen, arama sonuçlarında vermeyenlerin üstünde yer alırsın." />@endif
                                            </td>
                                            <td>
                                                @if(in_array($discount->id, [1]))
                                                    <input type="checkbox" name="discount[{{ $discount->id }}]" value="1" @if(Auth::user()->user_discounts->where('discount_id', $discount->id)->pluck('rate')->first() == 1){{'checked'}}@endif />
                                                @else
                                                <select name="discount[{{ $discount->id }}]" class="form-control">
                                                    <option value="">-- Yok --</option>
                                                    <option value="5"@if(Auth::user()->user_discounts->where('discount_id', $discount->id)->pluck('rate')->first() == 5) {{'selected'}}@endif>%5</option>
                                                    <option value="10"@if(Auth::user()->user_discounts->where('discount_id', $discount->id)->pluck('rate')->first() == 10) {{'selected'}}@endif>%10</option>
                                                    <option value="15"@if(Auth::user()->user_discounts->where('discount_id', $discount->id)->pluck('rate')->first() == 15) {{'selected'}}@endif>%15</option>
                                                </select>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ $discount->title }} Şartları</td>
                                            <td>
                                                <textarea name="discount_description[{{ $discount->id }}]" class="form-control" rows="3" placeholder="{{ Auth::user()->user_discounts->where('discount_id', $discount->id)->pluck('description')->first() ?? $discount->description }}">{{ Auth::user()->user_discounts->where('discount_id', $discount->id)->pluck('description')->first() }}</textarea>
                                                <small>{{ $discount->title }} seçtiysen varsayılan şartları değiştirebilirsin.</small>
                                            </td>
                                        </tr>    
                                        @if($discounts->count() != $key+1)
                                        <tr>
                                            <td colspan="2"><hr /></td>
                                        </tr>                            
                                        @endif                
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
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
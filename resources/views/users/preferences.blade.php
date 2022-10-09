@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
            <form action="{{ url('users/preferences') }}" method="post" class="ajax-form js-dont-reset">
                @csrf
                <div class="card box-shadow mb-4">
                    <div class="card-header">
                        <h4 class="mb-0 pt-3 pb-3">Tercihler</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td colspan="2"><strong>Eğitim Tercihleri</strong></td>
                                        </tr>
                                        <tr>
                                            <td  width="200">Ders Verilen Şekiller</td>
                                            <td>
                                                <div class="row">
                                                    @foreach($figures as $figure)
                                                    <div class="col-lg-4">
                                                        <input type="checkbox" name="figures[]" id="f{{ $figure->id }}" value="{{ $figure->id }}"@if(Auth::user()->user_figures->map->only('figure_id')->contains('figure_id', $figure->id)){{'checked'}}@endif> <label for="f{{ $figure->id }}">{{ $figure->title }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ders Verilen Mekanlar</td>
                                            <td>
                                                <div class="row">
                                                    @foreach($places as $place)
                                                    <div class="col-lg-4">
                                                        <input type="checkbox" name="places[]" id="p{{ $place->id }}" value="{{ $place->id }}"@if(Auth::user()->user_places->map->only('place_id')->contains('place_id', $place->id)){{'checked'}}@endif> <label for="p{{ $place->id }}">{{ $place->title }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ders Verilen Zamanlar</td>
                                            <td>
                                                <div class="row">
                                                    @foreach($times as $time)
                                                    <div class="col-lg-4">
                                                        <input type="checkbox" name="times[]" id="t{{ $time->id }}" value="{{ $time->id }}"@if(Auth::user()->user_times->map->only('time_id')->contains('time_id', $time->id)){{'checked'}}@endif> <label for="t{{ $time->id }}">{{ $time->title }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sunulan Hizmetler</td>
                                            <td>
                                                <div class="row">
                                                    @foreach($services as $service)
                                                    <div class="col-lg-4">
                                                        <input type="checkbox" name="services[]" id="s{{ $service->id }}" value="{{ $service->id }}"@if(Auth::user()->user_services->map->only('service_id')->contains('service_id', $service->id)){{'checked'}}@endif> <label for="s{{ $service->id }}">{{ $service->title }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ders Verilen Cinsiyetler</td>
                                            <td>
                                                <div class="row">
                                                    @foreach($genders as $gender)
                                                    <div class="col-lg-4">
                                                        <input type="checkbox" name="genders[]" id="g{{ $gender->id }}" value="{{ $gender->id }}"@if(Auth::user()->user_genders->map->only('gender_id')->contains('gender_id', $gender->id)){{'checked'}}@endif> <label for="g{{ $gender->id }}">{{ $gender->title }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><strong>Gizlilik Tercihleri</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Soyadı Gizliliği</td>
                                            <td>
                                            <select name="privacy_lastname" class="form-control">
                                                <option value="1" @if(Auth::user()->detail->privacy_lastname == 1) selected @endif>Soyadımı göster</option>
                                                <option value="2" @if(Auth::user()->detail->privacy_lastname == 2) selected @endif>Soyadım yerine Öğretmen yazsın</option>
                                            </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Telefon Gizliliği</td>
                                            <td>
                                            <select name="privacy_phone" class="form-control">
                                                <option value="1" @if(Auth::user()->detail->privacy_phone == 1) selected @endif>Telefon numaramı göster</option>
                                                <option value="3" @if(Auth::user()->detail->privacy_phone == 2) selected @endif>Telefon numaramı gizle</option>
                                            </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Yaş Gizliliği</td>
                                            <td>
                                            <select name="privacy_age" class="form-control">
                                                <option value="1" @if(Auth::user()->detail->privacy_age == 1) selected @endif>Yaşımı göster</option>
                                                <option value="2" @if(Auth::user()->detail->privacy_age == 2) selected @endif>Yaşımı gizle</option>
                                            </select>
                                            </td>
                                        </tr>    
                                        <tr>
                                            <td colspan="2"><strong>E-posta Tercihleri</strong></td>
                                        </tr>
                                        <tr>
                                            <td>E-posta Gönderim İzni</td>
                                            <td>
                                            <select name="email_list" class="form-control">
                                                <option value="1" @if(Auth::user()->detail->email_list == 1) selected @endif>Evet</option>
                                                <option value="2" @if(Auth::user()->detail->email_list == 0) selected @endif>Hayır</option>
                                            </select>
                                            </td>
                                        </tr>                                        
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
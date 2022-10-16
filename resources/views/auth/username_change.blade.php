@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Kullanıcı Adı Değiştir</h4>
                </div>
                <div class="card-body">
                    <p>Kullanıcı adını yalnızca bir defa değiştirebilirsin. Belirlediğin kullanıcı adı ile akılda kalıcı bir profil sayfası bağlantısına sahip olursun.<br /><br />Aşağıdaki örnekler gibi:<br />https://netders.com/ahmetdemir<br />https://netders.com/pratikakademi</p>
                    <form  action="{{ url('username/change') }}" method="post" class="ajax-form">
                        <div class="row">

                            <div class="form-group col-12">
                                <label class="d-block">Mevcut Kullanıcı Adı</label>
                                <span class="text-muted">https://netders.com/</span>{{ Auth::user()->username }}
                            </div>

                            <div class="form-group col-12">
                                <label>Yeni Kullanıcı Adı</label>
                                <input type="username" name="username" class="form-control mask-username" />
                                <small>Kullanıcı adında abcdefghijklmnopqrstuvwxyz harflerini ve - (orta çizgi) karakterlerini kullanabilirsin.</small>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary js-submit-btn">Kaydet</button>
                                <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Şifre Değiştir</h4>
                </div>
                <div class="card-body">
                    <p>Aşağıdaki alanlara mevcut şifreni, yeni şifreni ve yeni şifre tekrarını girerek şifreni değiştirebilirsin.</p>
                    <form  action="{{ url('password/change') }}" method="post" class="ajax-form">
                        <div class="row">

                            <div class="form-group col-12">
                                <label>Mevcut Şifre</label>
                                <input type="password" name="old_password" class="form-control" />
                            </div>

                            <div class="form-group col-12">
                                <label>Yeni Şifre</label>
                                <input type="password" name="new_password" class="form-control" />
                            </div>                     

                            <div class="form-group col-12">
                                <label>Yeni Şifre (Tekrar)</label>
                                <input type="password" name="new_password_confirmation" class="form-control" />
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
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">E-posta Değiştir</h4>
                </div>
                <div class="card-body">
                    <p>E-posta adresini değiştirmek için aşağıdaki alana yeni e-posta adresini girebilirsin.</p>
                    <form  action="{{ url('email/change') }}" method="post" class="ajax-form">
                        <div class="row">

                            <div class="form-group col-12">
                                <label class="d-block">Mevcut E-posta</label>
                                {{ Auth::user()->email }}
                            </div>

                            <div class="form-group col-12">
                                <label>Yeni E-posta</label>
                                <input type="email" name="email" class="form-control" />
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
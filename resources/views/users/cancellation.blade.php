@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            <div class="card box-shadow mb-4">
                <div class="card-header"><h4>Üyelik İptali</h4></div>
                <div class="card-body">
                    <p>⚠️ Üyeliğini iptal etmek istiyorsan aşağıdaki alana mevcut şifreni ve iptal nedenini girmelisin. Unutma, bu işlemin geri dönüşü yoktur.</p>
                    <form  action="{{ url('users/cancellation') }}" method="post" class="ajax-form">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Mevcut Şifre</label>
                                <input type="password" name="password" class="form-control" />
                            </div>

                            <div class="form-group col-md-12">
                                <label>İptal Nedeni</label>
                                <textarea name="cancel_reason" class="form-control"></textarea>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary js-submit-btn">Üyeliğimi İptal Et</button>
                                <button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            @include('utilities.alerts') 
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">😬 Ödeme Başarısız</h4>
                </div>
                <div class="card-body">
                    Üzgünüz! Ödeme işleminizde bir hata oluştu.
                    <br /><br />
                    Lütfen <a href="{{ url('cart') }}">buraya</a> tıklayarak alışveriş sepetine dönüp, tekrar deneyiniz.
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
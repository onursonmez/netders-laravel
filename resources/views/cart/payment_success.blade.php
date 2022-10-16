@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            @include('utilities.alerts') 
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">👏 Ödeme Başarılı</h4>
                </div>
                <div class="card-body">
                    Tebrikler! Ödeme işlemin başarıyla tamamlandı. Yaptığın ödeme ekstrende PAYTR ÖDEME veya NETDERS açıklamasıyla görünecektir.
                    <br /><br />
                    İşlemin, ödeme servis sağlayıcısının hile kontrol mekanizmalarından geçtikten sonra kesinleşecektir. İşleminin sonucunu çok kısa süre içerisinde e-posta olarak göndereceğiz. Eğer işlemin herhangi bir nedenden dolayı tamamlanamazsa ödediğin ücret otomatik olarak iade edilir.
                    <br /><br />
                    ❤️ Bize güvendiğin için teşekkürler.
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
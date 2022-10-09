@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            @include('utilities.alerts') 
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">Alışveriş Sepeti</h4>
                </div>
                <div class="card-body">

                    @if($items->count() > 0)
                    <table class="table">
                        <tbody>
                            <thead>
                                <th>Ürün Adı</th>
                                <th width="130" class="text-right">Ücret</th>
                                <th width="100" class="text-right">Kaldır</th>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    @if($item->product->product_category_id == 3)
                                    <td>{{ $item->product->title }} ({{ $item->lesson->teacher->first_name}}, {{\Carbon\Carbon::parse($item->lesson->start_at, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('d.m.Y H:i')}} - {{\Carbon\Carbon::parse($item->lesson->end_at, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('H:i')}})</td>
                                    @else
                                    <td>{{ $item->product->title }}</td>
                                    @endif
                                    <td width="130" class="text-right">{{ $item->price }} TL</td>
                                    <td width="100" class="text-right"><a href="{{ url('cart/remove/'.$item->id) }}"><img class="align-middle" src="{{ asset('img/navigation-close-small.svg') }}" width="14" height="14"></a></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td width="130" class="text-right"><strong>Toplam</strong></td>
                                    <td width="100" class="text-right">{{ number_format($items->pluck('price')->sum(), 2, '.', '') }} TL</td>
                                </tr>                                
                                <tr>
                                    <td></td>
                                    <td width="130" class="text-right"><strong>Ödenecek</strong></td>
                                    <td width="100" class="text-right">{{ number_format($items->pluck('price')->sum(), 2, '.', '') }} TL</td>
                                </tr>                                            
                                
                            </tbody>
                        </tbody>
                    </table>
                    @else
                    Alışveriş sepetinde herhangi bir ürün bulamadık. Ürünleri incelemek için <a href="{{ url('users/dashboard') }}">buraya</a> tıklayabilirsin.
                    @endif

                </div>
            </div>

            @if($items->count() > 0)
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">Ödeme</h4>
                </div>
                <div class="card-body">
                    <p>{{ config('app.name', 'Netders.com') }}, güvenliğin için hiçbir şekilde kredi kartı bilgilerini saklamaz. Bu nedenle kredi kartı bilgilerini her siparişinde tekrar girmek zorundasın.</p>
                    <p><input data-toggle="collapse" data-target="#odeme" type="checkbox" name="aggrement" id="aggrement" value="1" /> <a href="" class="loadModal" data-url="{{ url('contents/load/6') }}" data-title="Mesafeli Satış Sözleşmesi">Mesafeli satış sözleşmesi</a>ni okudum, kabul ediyorum.</p>
                    <div class="collapse" id="odeme">
                        <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
                        <iframe src="https://www.paytr.com/odeme/guvenli/{{ $token }}" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
                        <script>iFrameResize({},'#paytriframe');</script>
                    </div>
                </div>
            </div>
            @endif

        </div>
	</div>
</div>
@endsection
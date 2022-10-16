@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            @include('utilities.alerts') 
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">Hesap Hareketleri</h4>
                </div>
                <div class="card-body">

                    @if($orders->count() > 0)
                    <table class="table">
                        <tbody>
                            <thead>
                                <th>Ürün Adı</th>
                                <th class="text-right">Başlangıç Tarihi</th>
                                <th class="text-right">Sonlanma Tarihi</th>
                            </thead>
                            <tbody>
                                @foreach($orders as $item)
                                <tr>
                                    <td>{{ $item->product->title }}</td>
                                    <td class="text-right">{{ \Carbon\Carbon::parse($item->start_at)->timezone($item->user->timezone->code)->format('d.m.Y H:i') }}</td>
                                    <td class="text-right">{{ \Carbon\Carbon::parse($item->end_at)->timezone($item->user->timezone->code)->format('d.m.Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </tbody>
                    </table>
                    @else
                        Herhangi bir işlem hareketin bulunamadı.
                    @endif

                </div>
            </div>


        </div>
	</div>
</div>
@endsection
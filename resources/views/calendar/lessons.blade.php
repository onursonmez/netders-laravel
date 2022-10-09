@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            @include('utilities.alerts') 
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">Canlı Ders Hareketleri</h4>
                </div>
                <div class="card-body">
                    @if($lessons->count() > 0)
                    <table class="table">
                        <tbody>
                            <thead>
                                <th>Ders</th>
                                <th>Başlangıç Tarihi</th>
                                <th>Sonlanma Tarihi</th>
                                <th>Durum</th>
                                <th class="text-right">İşlemler</th>
                            </thead>
                            <tbody>
                                @foreach($lessons as $item)
                                <tr>
                                    <td>{{ $item->topic }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->start_at,'UTC')->setTimezone(Auth::user()->timezone->code)->format('d.m.Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->end_at,'UTC')->setTimezone(Auth::user()->timezone->code)->format('d.m.Y H:i') }}</td>
                                    <td>{{ Lang::get('cart.lesson_statuses')[$item->status] }}</td>
                                    <td class="text-right">
                                    <div class="dropdown" @if($item->status != 'A') data-toggle="tooltip" data-placement="top" title="Ders daha önce işleme alınmıştır." @endif>
                                        <img class="cursor-pointer" src="{{ asset('img/more.svg') }}" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" width="20"  />
                                        @if($item->status == 'A')
                                        <div class="dropdown-menu dropdown-menu-right"" aria-labelledby="dropdownMenuButton">
                                            @if($item->student_id == Auth::user()->id)
                                            <a class="dropdown-item loadModal" href="javascript:void(0);" data-url="{{ url('calendar/change/'.$item->id) }}" data-id="{{ $item->teacher_id }}" data-title="Tarih Değiştir">Tarih değiştir</a>
                                            <a class="dropdown-item loadModal" href="javascript:void(0);" data-url="{{ url('users/new_comment') }}" data-form-url="{{ url('calendar/approve') }}" data-id="{{ $item->id }}" data-title="Değerlendir ve Onay Ver">Onay Ver</a>
                                            <a class="dropdown-item loadModal" href="javascript:void(0);" data-url="{{ url('users/new_comment') }}" data-form-url="{{ url('calendar/disapprove') }}" data-id="{{ $item->id }}" data-title="Değerlendir ve İade Talebi Başlat">İade Talebi</a>
                                            @endif
                                        </div>
                                        @endif
                                    </div>                                    
                                    
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </tbody>
                    </table>
                    @else
                        @if(Auth::user()->is_teacher())
                        <p>Senden satın alınan ve senin satın aldığın canlı ders tarihlerini bu sayfada göreceksin.</p>
                        @else
                        <p>Satın aldığın canlı derslerin tarihlerini bu sayfada göreceksin.</p>
                        @endif
                    @endif

                    <small>
                        - Aldığın dersleri, ders başlamadan önce dilediğin zaman değiştirebilirsin.<br />
                        - İşlenen dersler için 7 gün içinde onay vermen gerekir. 7 gün içinde onay verilmeyen dersler otomatik olarak onaylanır.<br />
                        - Aldığın dersleri beğenmemen durumunda 7 gün içinde ücret iadesi talebinde bulunabilirsin.<br />
                        - Henüz başlamamış dersini iptal ederek ücret iadesi talep edebilirsin.
                    </small>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
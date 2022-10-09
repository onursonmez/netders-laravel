@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            <div class="card box-shadow mb-4">
                <div class="card-header">
                <h4 class="mb-0 pt-3 pb-3">Üyelik Durumu</h4>
                </div>
                <div class="card-body">

                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="30%">Kayıt Tarihi</td>
                                <td>{{ \Carbon\Carbon::parse(Auth::user()->created_at)->timezone(Auth::user()->timezone->code)->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <td width="30%">Üyelik Tipi</td>
                                <td>
                                    {{ Auth::user()->group->title }}
                                </td>
                            </tr>
                            @if(Auth::user()->group_id > 3 && Auth::user()->membership_expire())
                            <tr>
                                <td width="30%">Üyelik Sonlanma Tarihi</td>
                                <td>{{ \Carbon\Carbon::parse(Auth::user()->membership_expire()->end_at, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('d.m.Y H:i') }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Hizmetler</h4>
                </div>
                <div class="card-body">

                    <table class="table">
                        <thead>
                            <th>Hizmet Adı</th>
                            <th>Kullanım Durumu</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="30%">Uzman Eğitmen Rozeti</td>
                                <td>@if(Auth::user()->service_badge){{'Var'}}@else{{'Yok'}}@endif</td>
                            </tr>
                            <tr>
                                <td width="30%">Öne Çıkanlar</td>
                                <td>@if(Auth::user()->featured()){{'Var'}}@else{{'Yok'}}@endif</td>
                            </tr>     
                            <tr>
                                <td width="30%">Profesyonel Alan Adı</td>
                                <td>@if(Auth::user()->domain()){{'Var'}}@else{{'Yok'}}@endif</td>
                            </tr>                                                        
                            <tr>
                                <td width="30%">Profil Reklamı</td>
                                <td>@if(Auth::user()->ad()){{'Var'}}@else{{'Yok'}}@endif</td>
                            </tr>              
                            <tr>
                                <td width="30%">Ana Sayfa Vitrini</td>
                                <td>@if(Auth::user()->home()){{'Var'}}@else{{'Yok'}}@endif</td>
                            </tr>                                                                                                                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
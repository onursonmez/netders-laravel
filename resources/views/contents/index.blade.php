@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        <div class="col-lg-9">
            @include('utilities.alerts') 
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="pt-2">İçerikler</h4>
                </div>
                <div class="card-body">

                    <table class="table">
                        <tbody>
                            <thead>
                                <th>Başlık</th>
                                <th width="100" class="text-right">Kaldır</th>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td><a href="{{ url('contents/edit/'.$item->id) }}">{{ $item->title }}</a></td>
                                    <td width="100" class="text-right"><a href="{{ url('contents/delete/'.$item->id) }}"><img class="align-middle" src="{{ asset('img/navigation-close-small.svg') }}" width="14" height="14"></a></td>
                                </tr>
                                @endforeach
                                                                         
                                
                            </tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
	</div>
</div>
@endsection
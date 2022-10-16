@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 
        
        <div class="col-lg-9">
        @include('utilities.alerts')
            <div class="card box-shadow mb-4">
                <div class="card-header">
                    <h4 class="mb-0 pt-3 pb-3">Eksik Profil Alanları</h4>
                </div>
                <div class="card-body">
                    <div class="row">	
                        <div class="col-md-12">
                            <p>Profilinin arama sonuçlarında görünebilmesi için aşağıdaki alanların doldurulması gerekmektedir. Doldurmak istediğin alana tıklayarak ilgili sayfaya gidebilirsin.</p>
                            @if(!empty($required))
                            @foreach($required as $key => $value)
                            <a href="{{ $value[0] }}" class="block">{{ $key+1 }}. {{ $value[1] }}</a><br />
                            @endforeach
                            @endif
                        </div>				
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
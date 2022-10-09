@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card box-shadow mb-4">
        <div class="card-header">
            <h4 class="pt-2">{{ $category->title ?? '' }}</h4>
        </div>
        <div class="card-body">
            <form method="get" action="{{ url()->current() }}" />
                <div class="row mb-4">
                    <div class="col-10 col-md-4 offset-sm-0 offset-md-3">
                        <input type="text" name="q" class="form-control" value="{{ app('request')->input('q') }}" />
                    </div>
                    <div class="col-2 col-sm-6 col-md-4">
                        <button type="submit" class="btn btn-primary js-submit-btn">Ara</button>
                    </div>                    
                </div>
            </form>            
            @if(isset($contents) && $contents->count() > 0)
            @foreach($contents as $content)
            <div class="card mb-2 border border-light-blue">
                <div class="card-body">            
                    <div class="media media-list">
                        <div class="media-body">
                            <h4 class="mt-0"><a href="{{ url($content->slug) }}">{{ $content->title }}</a></h4>            

                            <small class="text-muted d-block mb-2">
                                    <img class="align-text-top" src="{{ asset('img/form-date-gray.svg') }}" width="13" height="13"> {{ \Carbon\Carbon::parse($content->created_at)->format('d.m.Y') }}
                            </small>

                            {{ truncate(strip_tags(html_entity_decode($content->description)), 200) }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            Arama sonuçlarına uygun içerik bulunamadı.
            @endif

            {{ isset($contents) ? $contents->links() : '' }}
        </div>
	</div>
</div>
@endsection
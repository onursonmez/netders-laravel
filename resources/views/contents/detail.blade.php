@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card mt-4 box-shadow rounded-top">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">{{ $content->title }}</h4>
		</div>
		<div class="card-body">
            <p>{!! $content->description !!}</p>
		</div>
	</div>
</div>
@endsection
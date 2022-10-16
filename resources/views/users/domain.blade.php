@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
			@include('utilities.alerts') 
			<form  action="@if(Session::get('success')){{ url('domain/select') }}@else{{ url('domain/check') }}@endif" method="post">
				@csrf
				<div class="card box-shadow mb-4">
					<div class="card-header">
						<h4 class="mb-0 pt-3 pb-3">Profesyonel Alan Adı</h4>
					</div>
					<div class="card-body">
						<p>Aşağıdaki alana istediğin alan adını yazıp kontrol edebilirsin.</p>
						<div class="row">
							<div class="col-12">
								@if(Session::get('success'))
								<p><strong>{{ Session::get('domain') }}{{ Session::get('ext') }}</strong></p>
								<input type="hidden" name="domain" value="{{ Session::get('domain') }}" />
								<input type="hidden" name="ext" value="{{ Session::get('ext') }}" />
								@else
								<div class="form-inline">
									<div class="form-group mb-2 mr-2">
										<input type="text" name="domain" class="form-control" style="min-width:300px" value="{{ Session::get('domain') }}" />
									</div>
									<div class="form-group mb-2">
										<select name="ext" class="form-control select2 mb-2">
											<option value=".com" @if(Session::get('ext') == '.com'){{ 'selected' }}@endif>.com</option>
											<option value=".net" @if(Session::get('ext') == '.net'){{ 'selected' }}@endif>.net</option>
											<option value=".org" @if(Session::get('ext') == '.org'){{ 'selected' }}@endif>.org</option>
										</select>
									</div>							
								</div>
								@endif
							</div>
							@if(Session::get('domain'))
							<div class="col-12">
								<p>{{ Session::get('message') }}</p>
								@if(Session::get('success'))
								<p><a href="{{ url('domain') }}">Başka bir alan adı ara</a></p>
								@endif
							</div>							
							@endif
							<div class="col-12 mt-2">
								@if(Session::get('success'))
								<button type="submit" class="btn btn-primary js-submit-btn">Alan adını seç</button>
								@else
								<button type="submit" class="btn btn-primary js-submit-btn">Kontrol et</button>
								@endif
							</div>
						</div>
					</div>
				</div>


			</form>		
		</div>
	</div>
</div>
@endsection
<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Tanımlı Ders Verilen Bölgeler</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Lokasyon Adı</th>
					<th class="text-right">İşlemler</th>
				</tr>
			</thead>
			<tbody>
				@foreach($locations as $item)
				<tr id="location_item_{{ $item->id }}">
					<td class="align-middle">{{$item->city->title}} > {{$item->town->title}}</td>
					<td class="align-middle text-right"><img src="{{ asset('img/action-delete.svg') }}" class="js-link" onclick="location_delete({{ $item->id }})" width="13" height="13" data-toggle="tooltip" data-placement="top" title="Sil" /></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		</div>
	</div>
</div>
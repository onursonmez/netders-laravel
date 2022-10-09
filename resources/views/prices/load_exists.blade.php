<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Tanımlı Ders Ücretleri</h4>
	</div>
	<div class="card-body">
		<p>Ücret belirlediğin derslere tanıtım yazısı yazarak profilini ziyaret eden öğrencilerin sayısını arttırabilirsin. Tanıtım yazısı yazdığın dersler için özel sayfalar oluşturuyoruz ve profilini daha fazla öğrencinin ziyaret etmesini sağlıyoruz.</p>
		<p>Tanıtım yazısı yazmak istediğin dersin sırasındaki <u>Tanıtım</u> altındaki ikona veya ders adına tıklayarak o ders için tanıtım yazısı ekleyebilir veya daha önceden eklemiş olduğun tanıtım yazısını değiştirebilirsin.</p>
		<p>Ders tanıtımı alanındaki görsellerin anlamları aşağıdadır:</p>
		<p>
			<ul class="list-group list-group-flush">
			<li class="list-group-item"><img src="{{ asset('img/messaging-declined.svg') }}" width="13" height="13" /> ders tanıtımı yapılmadı</li>
			<li class="list-group-item"><img src="{{ asset('img/messaging-info.svg') }}" width="13" height="13" /> ders tanıtımı onay bekliyor</li>
			<li class="list-group-item"><img src="{{ asset('img/messaging-success.svg') }}" width="13" height="13" /> ders tanıtımı yapıldı ve onaylandı</li>
			</ul>
		</p>
		<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Ders Adı</th>
					<th>Birebir Ders Ücreti (TL / Saat)</th>
					<th>Canlı Ders Ücreti (TL / Saat)</th>
					<th class="text-center">Tanıtım</th>
					<th>İşlemler</th>
				</tr>
			</thead>
			<tbody>
				@foreach($prices as $item)
				<tr id="price_item_{{ $item->id }}">
					<td class="align-middle"><a href="javascript:void(0)" onclick="price_text({{ $item->id }})">{{$item->subject->title}} > {{$item->level->title}}</a></td>
					<td><input type="text" name="items[{{ $item->id }}][price_private]" class="form-control" value="{{ $item->price_private }}" /></td>
					<td><input type="text" name="items[{{ $item->id }}][price_live]" class="form-control" value="{{ $item->price_live }}" /></td>
					<td class="align-middle text-center">
						<a href="javascript:void(0)" onclick="price_text({{ $item->id }})">
						@if(!$item->status)
						    <img src="{{ asset('img/messaging-declined.svg') }}" width="13" height="13" data-toggle="tooltip" data-placement="top" title="Ders tanıtımı yapılmadı" />
						@elseif($item->status == 'W')
						    <img src="{{ asset('img/messaging-info.svg') }}" width="13" height="13" data-toggle="tooltip" data-placement="top" title="Ders tanıtımı onay bekliyor" />
						@else
						    <img src="{{ asset('img/messaging-success.svg') }}" width="13" height="13" data-toggle="tooltip" data-placement="top" title="Ders tanıtımı yapıldı" />
						@endif
						</a>
					</td>
					<td class="align-middle text-center"><img src="{{ asset('img/action-delete.svg') }}" class="js-link" onclick="price_delete({{ $item->id }})" width="13" height="13" data-toggle="tooltip" data-placement="top" title="Sil" /></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		</div>

		<div class="row">
			<div class="col-12">
				<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
				<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Prices -->
<div class="modal fade" id="price_text_modal" tabindex="-1" role="dialog" aria-labelledby="pricesLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<input type="hidden" id="id" name="id" />
			<input type="text" id="title" maxlength="140" name="title" class="form-control" placeholder="Başlık" />
			<textarea rows="7" id="description" maxlength="1000" data-type="count" data-length="1000" name="description" class="form-control mt-2"  placeholder="Açıklama"></textarea>
			<small id="description_count">1000 karakter kaldı</small>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick="price_text_save()">Kaydet</button>
		</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="form-group col-12 mb-0">
    <label>Dersler</label>
</div>

@foreach($items as $item)
<div class="col-lg-4">
    <input type="checkbox" name="levels[]" id="label_level_{{ $item->id }}" value="{{ $item->id }}" /> <label for="label_level_{{ $item->id }}">{{ $item->title }}</label>
</div>
@endforeach

<div class="col-12"></div>

<div class="form-group col-lg-6 mt-2">
    <label>Birebir Ders Ücreti (TL / Saat)</label>
    <input type="text" name="price_private" class="form-control" placeholder="50" />
</div>

<div class="form-group col-lg-6 mt-2">
    <label>Canlı Ders Ücreti (TL / Saat)</label>
    <input type="text" name="price_live" class="form-control" placeholder="40" />
</div>

<div class="col-12">
    <button type="submit" class="btn btn-primary js-submit-btn">Ekle</button>
    <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
</div>

<div class="col-12">
    <label>İlçeler</label>
</div>

@foreach($items as $item)
<div class="col-lg-4">
    <input type="checkbox" name="towns[]" id="label_town_{{ $item->id }}" value="{{ $item->id }}" /> <label for="label_town_{{ $item->id }}">{{ $item->title }}</label>
</div>
@endforeach

<div class="col-12"></div>

<div class="col-12">
    <button type="submit" class="btn btn-primary js-submit-btn">Ekle</button>
    <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
</div>

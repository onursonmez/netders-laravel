<form  action="{{ url('calendar/change') }}" method="post" class="ajax-form js-dont-reset">
    @csrf
    <div class="form-group mb-2" style="min-width:180px">Yeni Tarih</div>

    <div class="form-group mb-2 mr-2">
        <input type="text" name="date" class="form-control date" value="{{ \Carbon\Carbon::parse($lesson->start_at, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('d.m.Y') }}" />
    </div>

    <div class="form-group mb-2">
        <select name="time" class="form-control select2 mb-2">
            @foreach($times as $time)
                <option value="{{ $time->format('H:i') }}" @if(\Carbon\Carbon::parse($lesson->start_at, 'UTC')->setTimezone(Auth::user()->timezone->code)->format('H:i') == $time->format('H:i')){{'selected'}}@endif>{{ $time->format('H:i') }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-2">
        <button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
        <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
    </div>
    <input type="hidden" name="lesson_id" value="{{ $lesson->id }}" />
</form>

<script type="text/javascript" src="{{ asset('vendor/mask/jquery.mask.min.js') }}"></script>
<script>

var date = document.querySelector('.date');
if(date)
{
$('.date').each(function(){
    $(this).mask("00.00.0000", {placeholder: "__.__.____"});
});
    
}
</script>
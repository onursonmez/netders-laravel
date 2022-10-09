<div class="form-group mb-2" style="min-width:180px">Ders adı</div>
<div class="form-group mb-2">
    <select name="loaded_lesson" id="loaded_lesson" class="form-control">
        <option value=""> -- Lütfen seçin --</option>
        @foreach($prices as $item)
            @if($item->price_live > 0)
                <option value="{{ $item->id }}" @if($item->id == $lesson_id){{ 'selected' }}@endif>{{$item->subject->title}} > {{$item->level->title}}</option>
            @endif
        @endforeach
    </select>
</div>

<div class="form-group mt-3 mb-2">Ders süresi</div>
<div class="form-group mb-2">
    <select name="loaded_minute" id="loaded_minute" class="form-control">
        <option value="">-- Lütfen seçin --</option>
        @for($i=$definition->lesson_min_minute ?? 30; $i <= $definition->lesson_max_minute ?? 180; $i+=15)
            <option value="{{ $i }}" @if($i == $lesson_minute OR ($definition->lesson_min_minute ?? '') == $i){{'selected'}}@endif>{{ $i }} dakika</option>
        @endfor
    </select>                        
</div>

<script>
    $('#loaded_lesson').on('change', function(){
        $('#lesson_id').val($('#loaded_lesson option:selected').val());
        $('#lesson_minute').val($('#loaded_minute option:selected').val());
        $('.fc-selectLessonButton-button').html($('#loaded_lesson option:selected').text());
    });

    $('#loaded_minute').on('change', function(){
        $('#lesson_minute').val($('#loaded_minute option:selected').val());
    });    
</script>

<button type="submit" class="btn btn-primary js-submit-btn mt-2" data-dismiss="modal">Tamam</button>
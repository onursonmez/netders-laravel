<form method="POST" action="{{ url('calendar/approve') }}" class="ajax-form">
    <div class="row">
        <div class="col-lg-12 mb-2">
            <select name="rating" class="form-control mb-2">
                <option value="">-- Verdiğin Puan --</option>
                <option value="1">1 (Berbat)</option>
                <option value="2">2 (Fena Değil)</option>
                <option value="3">3 (Normal)</option>
                <option value="4">4 (İyi)</option>
                <option value="5">5 (Mükemmel)</option>
            </select>
        </div>

        <div class="col-lg-12 mb-2">
            <textarea name="comment" rows="5" placeholder="Yorumunu buraya yazabilirsin" class="form-control mb-2"></textarea>
        </div>

        <div class="col-12 text-right">
            <button type="submit" class="btn btn-primary js-submit-btn">Kaydet</button>
            <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
        </div>                
    </div>
    <input type="hidden" name="user_id" id="user_id" />
    @csrf
</form>
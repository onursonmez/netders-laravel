<form method="POST" action="{{ url('users/send_complaint') }}" class="ajax-form">
    <div class="row">
        <div class="col-md-6 mb-2">
            <label>Adın</label>
            <input type="text" name="first_name" class="form-control" value="@if(Auth::check()){{ Auth::user()->first_name }}@endif" />
        </div>

        <div class="col-md-6 mb-2">
            <label>Soyadın</label>
            <input type="text" name="last_name" class="form-control" value="@if(Auth::check()){{ Auth::user()->last_name }}@endif" />
        </div>
        <div class="col-md-6 mb-2">
            <label>E-posta Adresin</label>
            <input type="email" name="email" class="form-control" value="@if(Auth::check()){{ Auth::user()->email }}@endif" />
        </div>

        <div class="col-md-6 mb-2">
            <label>Cep Telefonu Numaran</label>
            <input type="text" name="intl-mobile" data-type="mobile-number" class="form-control" />
        </div>
        
        <div class="col-md-12 mb-2">
            <label>Şikayetin</label>
            <textarea name="message" rows="5" class="form-control"
                placeholder="Lütfen şikayetini buraya yaz"></textarea>
        </div>

        <div class="col-12 text-right">
            <button type="submit" class="btn btn-primary js-submit-btn">Kaydet</button>
            <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
        </div>        
        
    </div>
    <input type="hidden" name="data_id" id="data_id" />
    @csrf
</form>

<script>

var input = document.querySelector('[data-type="mobile-number"]');
	if(input)
	{
		var iti = intlTelInput(input, {
			utilsScript: base_url + "vendor/intl-tel-input/build/js/utils.js?7",
			initialCountry: "tr",
			preferredCountries: ["tr", "de", "us"],
			hiddenInput: "phone_mobile",
		});

		$(input).on('focus', function(){
			var $this = $(this),
				// Get active country's phone number format from input placeholder attribute
				activePlaceholder = $this.attr('placeholder'),
				// Convert placeholder as exploitable mask by replacing all 1-9 numbers with 0s
				newMask = activePlaceholder.replace(/[1-9]/g, "0");
				// console.log(activePlaceholder + ' => ' + newMask);
		
			// Init new mask for focused input
			$this.mask(newMask);
		});
	}
</script>
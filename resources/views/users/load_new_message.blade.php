<form method="POST" action="{{ url('chat/send') }}" class="ajax-form">
    <div class="row">
        <div class="col-md-12 mb-2">
            <label>Mesajın</label>
            <textarea name="message" rows="5" class="form-control"
                placeholder="Mesajını buraya yazabilirsin"></textarea>
        </div>

		<div class="col-12 text-right">
            <button type="submit" class="btn btn-primary js-submit-btn">Kaydet</button>
            <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
        </div>        		
    </div>
    <input type="hidden" name="user_id" id="data_id" />
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
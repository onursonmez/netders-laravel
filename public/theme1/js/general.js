(function($){
    
    "use strict";

    $.ajaxSetup({
		dataType: 'json',
		headers:{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
    });

	$(document).on('submit', '.ajax-form', function(){
		var options = {
			beforeSubmit:  setLoader,
			success:       getResponseSuccess,
			error:         getResponseError
		};

		$(this).ajaxSubmit(options);

		return false;
	});    
    
}(jQuery));



function setLoader(formData, jqForm, options)
{
	jqForm.find(".js-loader").removeClass('d-none');
	jqForm.find(".js-submit-btn").hide();
}

function getResponseSuccess(responseText, statusText, xhr, form)
{
	if(typeof responseText.success !== "undefined")
	{
		$('.modal').modal('hide');

		$.each(responseText.success, function(i, item) {
			jgrowl(item);
		});
	}

	if(typeof responseText.call !== "undefined")
	{
		eval(responseText.call);
	}
		

	if(!$('.ajax-form').hasClass('js-dont-reset'))
		$('.ajax-form').trigger('reset');
	
	var file_input = document.querySelector('[type="file"]');
	if(file_input)
	{
		$(file_input).val('');
	}

	if(typeof responseText.redirect !== "undefined"){
		jgrowl('<i class="fa fa-refresh fa-pulse fa-fw"></i> Yönlendiriliyorsun... Yönlendirme gerçekleşmezse lütfen <a href="'+responseText.redirect+'">buraya</a> tıkla.');
		setTimeout(function(){
			location.href = responseText.redirect;
		}, 5000);
	} else {
		$(".js-loader").addClass('d-none');
		$(".js-submit-btn").show();

		if(document.getElementById('captcha-code'))
		document.getElementById('captcha-code').src='/captcha/math?'+Math.random();
	}
}

function getResponseError(responseText, statusText, xhr, form)
{
	var responseText = JSON.parse(responseText.responseText);
	
	if(typeof responseText.errors !== "undefined")
	{
		$.each(responseText.errors, function(i, item) {
		    jgrowl(item, 'red');
		});
	}

	if(typeof responseText.redirect !== "undefined"){
		jgrowl('<i class="fa fa-refresh fa-pulse fa-fw"></i> Yönlendiriliyorsunuz, lütfen bekleyiniz... Yönlendirme gerçekleşmezse lütfen <a href="'+responseText.redirect+'">buraya</a> tıklayınız.', 'red');
		setTimeout(function(){
			location.href = responseText.redirect;
		}, 5000);
	} else {
		$(".js-loader").addClass('d-none');
		$(".js-submit-btn").show();
	}
	
	if(document.getElementById('captcha-code'))
	document.getElementById('captcha-code').src='/captcha/math?'+Math.random();
}

function jgrowl(msg, theme){
	$.jGrowl(msg, { theme: theme, life: 10000 });
}

function mobile_phone(hash)
{
  $.post(base_url + 'users/mobile_phone?hash=' + hash, function(data){
	if(data)
	{
    	$('.ajaxmobile span').html(data);
    }
  });
}
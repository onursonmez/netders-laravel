$(function()
{
	$.ajaxSetup({
		dataType: 'json',
		headers:{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
	});

	$('.loadModal').on('click', function(e){
		e.preventDefault();
		
		var url = $(this).attr('data-url');
		var title = $(this).attr('data-title');
		var data_id = $(this).attr('data-id');
		var form_url = $(this).attr('data-form-url');
	
		$('#dynamic_modal h5').html('');
		$('#dynamic_modal .modal-body').html('');
		$('#dynamic_modal #data_id').val('');
	
		$.get(url, {form_url: form_url}, function(res){
		  $('#dynamic_modal h5').html(title);
		  $('#dynamic_modal .modal-body').html(res.html);
		  $('#dynamic_modal #data_id').val(data_id);
		  $('#dynamic_modal').modal('show');
		});
		
	  });
	  
	$('#informations-txt').length && $('#informations-txt').modal('show');

	$('[data-toggle="tooltip"]').tooltip();
	
	$(".tofirstupper").bind("keyup", function(e) {
		if($(this).val().length > 2){
			$(this).val($(this).val().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter){ return letter.replace("i","İ").toUpperCase(); } ));
		}
	});

	$("#city_id").length && $("#town_id").remoteChained("#city_id", base_url + "town/search", {selected: town_id});
	if($("#city_id").length){
		$("#city_id").trigger('change');
	}

	$("#subject_id").length && $("#level_id").remoteChained("#subject_id", base_url + "level/search", {selected: level_id});
		if($("#subject_id").length){
		$("#subject_id").trigger('change');
	}

	if($('[data-type="count"]').length){
		$.each($('[data-type="count"]'), function(i, item) {
			$(this).next('small').html($(this).attr('data-length') - $(this).val().length + ' karakter kaldı');
		});
	}

	$('[data-type="count"]').on('keyup', function(){
		$(this).next('small').html($(this).attr('data-length') - $(this).val().length + ' karakter kaldı');
	});

	$('.js-click-on-loading').on('click', function(){
		var url = $(this).attr('href');
		$(this).removeAttr('href').html('<i class="fa fa-spinner fa-pulse"></i> Lütfen bekleyiniz...');
		location.href = url;
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


	$(".scrollto").click(function(event) {
		event.preventDefault();

		var defaultAnchorOffset = 0;

		var anchor = $(this).attr('data-attr-scroll');

		var anchorOffset = $('#'+anchor).attr('data-scroll-offset');
		if (!anchorOffset)
			anchorOffset = defaultAnchorOffset;

		$('html,body').animate({
			scrollTop: $('#'+anchor).offset().top - anchorOffset - 20
		}, 500);
	});

	$('[data-load-from="selectbox"]').on('change', function(){
		var data_load_url = $(this).attr('data-load-url');
		var data_load_to = $(this).attr('data-load-to');

		$.get(data_load_url, 'selected_id='+$(this).val(), function(res){
			$('#' + data_load_to).html('');
			$('#' + data_load_to).html(res.html);
		});
	});

	$('.ajax-location-form #city_id').on('change', function(){
		$.get($(this).attr('data-url'), 'city_id='+$(this).val(), function(res){
			$("#town_ids").html("");
			$("#town_ids_tmpl").tmpl(res).appendTo("#town_ids");
		});
	});	

});

function load(url, to)
{
	$.ajax({
		url: url,
		success: function(res) {
			$('body #' + to).html('');
			$('body #' + to).html(res.html);
		}
	}).done(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});		
}
function jgrowl(msg, theme){
	$.jGrowl(msg, { theme: theme, life: 10000 });
}

function price_delete(id)
{
	$.ajax({
		url: base_url + 'prices/delete?id='+id,
		type: 'DELETE',
		success: function(result) {
			$('#price_item_' + id).fadeOut();
		}
	});	
}

function price_text(id)
{
	$('#price_text_modal h5').html('');
	$('#price_text_modal #id').val('');
	$('#price_text_modal #title').val('');
	$('#price_text_modal #description').val('');

	$.get(base_url + 'prices/text/'+id, function(res){
		$('#price_text_modal h5').html('(' + res.subject.title + ' > ' + res.level.title + ') Dersi İçin Tanıtım Yazısı Yaz');
		$('#price_text_modal #id').val(res.id);
		$('#price_text_modal #title').val(res.title);
		$('#price_text_modal #description').val(res.description);

		$('#price_text_modal').modal('show');
	});

	return false;
}

function price_text_save()
{
	var id = $('#price_text_modal #id').val();
	var title = $('#price_text_modal #title').val();
	var description = $('#price_text_modal #description').val();

	$.ajax({
		url: base_url + 'prices/text',
		data: 'id='+id+'&title='+title+'&description='+description,
		type: 'POST',
		success: function(result) 
		{
			$('#price_text_modal').modal('hide');
			$('#price_text_modal h5').html('');
			$('#price_text_modal #id').val('');
			$('#price_text_modal #title').val('');
			$('#price_text_modal #description').val('');	

			$('#price_text_modal').on('hidden.bs.modal', function () {
				load(base_url + 'prices/load_exists/' + result.user_id, 'load');
				jgrowl(result.success);				
			});
		},
		error: function(result)
		{		
			var responseText = JSON.parse(result.responseText);

			if(typeof responseText.errors !== "undefined")
			{
				$.each(responseText.errors, function(i, item) {
					jgrowl(item, 'red');
				});
			}
		}
	});	

	return false;
}

function location_delete(id)
{
	$.ajax({
		url: base_url + 'locations/delete?id='+id,
		type: 'DELETE',
		success: function(result) {
			$('#location_item_' + id).fadeOut();
		}
	});	
}

function checkCart()
{
	$.get(base_url + 'services/check_cart', function( res ) {
		if(res > 0){
			$('#shopping_cart').removeClass('hide');
			$('#shopping_cart .badge').html(res);
		} else {
			$('#shopping_cart').addClass('hide');
		}
	});
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

function open_window(url, target, specs)
{
	window.open(
	  url,
	  target,
	  specs
	);
}

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
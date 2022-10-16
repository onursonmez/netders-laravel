@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js" integrity="sha512-9pGiHYK23sqK5Zm0oF45sNBAX/JqbZEP7bSDHyt+nT3GddF+VFIcYNqREt0GDpmFVZI3LZ17Zu9nMMc9iktkCw==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.css" integrity="sha512-949FvIQOibfhLTgmNws4F3DVlYz3FmCRRhJznR22hx76SKkcpZiVV5Kwo0iwK9L6BFuY+6mpdqB2+vDIGVuyHg==" crossorigin="anonymous" />
<style>
img {
      max-width: 100%;
    }    
</style>
<div class="container">
	<div class="card mt-4 box-shadow rounded-top">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Fotoğraf Onayla</h4>
		</div>
		<div class="card-body">
            <div>
                <img id="image" src="{{ asset($photo->url) }}" />
            </div>
            

            <div class="btn-group">
            <button type="button" class="btn btn-primary mt-3" id="crop">Kırp</button>
            <button type="button" class="btn btn-primary mt-3" id="rotate">Döndür</button>
            <button type="button" class="btn btn-primary mt-3" id="decline">Reddet</button>
            </div>
        
		</div>
	</div>
</div>
<script>
window.addEventListener('DOMContentLoaded', function () {
    var image = document.querySelector('#image');
    var crop = document.getElementById('crop');
    var rotate = document.getElementById('rotate');
    var decline = document.getElementById('decline');
    var canvas;
    var cropper = new Cropper(image, {
    aspectRatio: 1,
        viewMode: 1,        
    });

    crop.onclick = function () {
        
        canvas = cropper.getCroppedCanvas();
        
        canvas.toBlob(function (blob) {
            var formData = new FormData();
            formData.append('photo', blob, 'photo.jpg');
            formData.append('user_id', {{ $photo->user_id }});
            formData.append('id', {{ $photo->id }});
            $.ajax(base_url+'cp/photo_approval', {
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function () {
                location.reload();
              },              
            });
        });
    };

    rotate.onclick = function () {
        cropper.rotate(45);
    };    

    decline.onclick = function () {
        var formData = new FormData();
        formData.append('id', {{ $photo->id }});
        $.ajax(base_url+'cp/photo_decline', {
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                location.reload();
            },              
        });
    }    
});
</script>
@endsection
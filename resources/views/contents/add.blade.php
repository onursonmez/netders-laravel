@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('utilities.my_sidebar') 

        <div class="col-lg-9">
			@include('utilities.alerts') 
			<form  action="{{ url('contents/save') }}" method="post" class="ajax-form js-dont-reset" enctype="multipart/form-data">
				@csrf
				<div class="card box-shadow mb-4">
					<div class="card-header">
						<h4 class="mb-0 pt-3 pb-3">Yeni İçerik</h4>
					</div>
					<div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Başlık</label>
                                <input type="text" name="title" class="form-control" value="{{ $content->title ?? '' }}" />
                            </div>

                            <div class="form-group col-12">
                                <label>Kategori</label>
                                <select name="category_id" class="form-control select2">
                                    <option value="">-- Lütfen Seçiniz --</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category_id') == $category->id || isset($content) && $content->content_category_id == $category->id) selected @endif><?=$category->title?></option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group col-12">
                                <label>Açıklama</label>
                                <textarea name="description" id="mytextarea">{{ $content->description ?? '' }}</textarea>
                            </div>

                            @if(isset($content->id))
                            <div class="form-group col-12">
                                <label>SEO URL</label>
                                <input type="text" name="slug" class="form-control" value="{{ $content->slug ?? '' }}" />
                            </div>     
                            
                            <div class="form-group col-12">
                                <label>SEO Başlık</label>
                                <input type="text" name="seo_title" class="form-control" value="{{ $content->seo_title ?? '' }}" />
                            </div>    

                            <div class="form-group col-12">
                                <label>SEO Açıklama</label>
                                <input type="text" name="seo_description" class="form-control" value="{{ $content->seo_description ?? '' }}" />
                            </div>                                
                            @endif                             

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary js-submit-btn">Kaydet</button>
                                <button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="{{ asset('img/spin.svg') }}" width="13" height="13" /> Lütfen bekleyiniz...</button>
                            </div>
                        </div>
					</div>
                </div>
                <input type="hidden" name="id" value="{{ $content->id ?? '' }}" />
			</form>		
		</div>
	</div>
</div>

<script src="https://cdn.tiny.cloud/1/nf70130we4aihat02zt23dxl32xlm3lh46omz3wkwtwz6jke/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
      tinymce.init({
        selector: '#mytextarea',
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_class_list: [
            { title: 'None', value: '' },
            { title: 'Some class', value: 'class-name' }
        ],
        importcss_append: true,
        file_picker_callback: function (callback, value, meta) {
            /* Provide file and text for the link dialog */
            if (meta.filetype === 'file') {
            callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
            }

            /* Provide image and alt text for the image dialog */
            if (meta.filetype === 'image') {
            callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
            }

            /* Provide alternative source and posted for the media dialog */
            if (meta.filetype === 'media') {
            callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
            }
        },
        templates: [
                { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
            { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
            { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
        ],
        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        skin: 'oxide',
        content_css: 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
      });
    </script>

@endsection
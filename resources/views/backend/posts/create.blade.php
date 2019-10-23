@extends('backend.index') @section('section') {!! Form::open(['url' => route('posts.store'), 'class'=>'row', 'method'=>'POST','enctype'=>'multipart/form-data']) !!}

<div class="col-sm-12 form-row mT-10 mB-10">
	<h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
	<div class="text-right col-sm-6">

		{!! Html::link(route('posts.index'),'Вернуться к списку',['class'=>'btn cur-p btn-secondary']) !!} {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}

	</div>
</div>

<ul class="nav nav-tabs col-sm-12 nav-main">
	<li><a href="#tab-1" data-toggle="tab" class="active">Основное</a></li>
	<li><a href="#tab-2" data-toggle="tab">SEO</a></li>
</ul>

<div class="tab-content col-sm-12">

	<div class="tab-pane active" id="tab-1">
		<div class="form-row">
			<div class="col-md-6">
				<div class="bgc-white p-20 bd">
					<div class="mT-30">
						<div class="form-row">
							<div class="form-group col-sm-12">
								{{ Form::label('name', 'Название') }} {{ Form::text('name', null, array('class'=>'form-control')) }}
							</div>
							<div class="form-group col-sm-12">
								{{ Form::label('status', 'Статус') }} {{ Form::select('status', array('published' => 'Опубликованно', 'draft' => 'Черновик'), null, array('class'=>'form-control')) }}
							</div>
							<div class="form-group col-sm-12 mT-30">
                               <div class="checkbox checkbox-circle checkbox-info peers mL-5">
                                   {{ Form::checkbox('is_top', 0, false, array('class' => 'peer', 'id' => 'is_top')) }}
                                   {{ Form::label('is_top', 'Выводить в верхнем блоке') }}    
                               </div>
                            </div> 
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="bgc-white p-20 bd">
					<div class="mT-30">
						<div class="form-row">
							<div class="form-group col-md-6">
								{{ Form::label('image', 'Фото') }} {!! Form::file('image', array('class' => 'general-img')) !!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 mT-30">
				<div class="bgc-white p-20 bd">
					{{ Form::label('text', 'Текст') }} {{ Form::textarea('text', null, array('id'=>'editor1')) }}
					<div class="form-row">
						<div class="form-group col-sm-12 mT-20">
							{{ Form::label('quote', 'Короткое описание') }} {{ Form::textarea('quote', null, array('class' => 'form-control')) }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="tab-pane" id="tab-2">
		<div class="form-row">
			<div class="col-md-12">
				<div class="bgc-white p-20 bd">
					<div class="mT-30">
						<div class="form-group">
							{{ Form::label('slug', 'ЧПУ') }} {{ Form::text('slug', null, array('class'=>'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('seo_title', 'SEO Title') }} {{ Form::text('seo_title', null, array('class'=>'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('seo_descr', 'SEO Description') }} {{ Form::textarea('seo_descr', null, array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

{!! Form::close() !!}
<style>
    .fileuploader {
        padding: 0;
        background: none;
    }
            
    .fileuploader-theme-thumbnails .fileuploader-thumbnails-input, 
    .fileuploader-theme-thumbnails .fileuploader-items-list .fileuploader-item {
        width: calc(50% - 16px);
        padding-top: calc(50% - 16px);
        margin-top: 0;

    }
</style>
<script>
	$(document).ready(function() {
		ClassicEditor
			.create(document.querySelector('#editor1'), {
				toolbar: ['heading', '|', 'bold', 'bulletedList', 'numberedList', 'blockQuote', 'link'],
				language: 'ru'
			})
			.then(editor => {
				window.editor = editor;
			})
			.catch(err => {
				console.error(err.stack);
			});
	});

</script>
@endsection

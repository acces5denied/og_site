@extends('backend.index') 
@section('section')
    
{!! Form::open(['url' => route('banners.store'), 'class'=>'row', 'method'=>'POST','enctype'=>'multipart/form-data']) !!}
    
<div class="col-sm-12 form-row mT-10 mB-10">
    <h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
    <div class="text-right col-sm-6">
       
        {!! Html::link(route('banners.index'),'Вернуться к списку',['class'=>'btn cur-p btn-secondary']) !!}
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        
    </div>
</div>

<div class="col-sm-12 mT-20">
    <div class="form-row bgc-white bd">
        <div class="col-md-6" >
            <div class="p-20">
                <div class="form-group">
                    {{ Form::label('name', 'Название') }}
                    {{ Form::text('name', null, array('class'=>'form-control')) }}  
                </div>
                <div class="form-group">
                    {{ Form::label('descript', 'Описание') }}
                    {{ Form::text('descript', null, array('class'=>'form-control')) }}  
                </div>
                <div class="form-group">
                    {{ Form::label('link', 'Ссылка') }}
                    {{ Form::text('link', null, array('class'=>'form-control')) }}  
                </div>
                <div class="form-group">
                    <strong>Расположение:</strong> 
                    <div class="form-checks mT-10">
                        <label for="block_1" class="form-check-label">
                            {{ Form::radio('block', 'block_1', true, array('class' => 'form-check-input', 'id' => 'block_1')) }}
                            <img src="/images/svg/block_1.svg" alt="">
                        </label> 
                        <label for="block_2" class="form-check-label">
                            {{ Form::radio('block', 'block_2', false, array('class' => 'form-check-input', 'id' => 'block_2')) }}
                            <img src="/images/svg/block_2.svg" alt="">
                        </label>   
                    </div>
                         
                </div>     
            </div>
        </div>
        <div class="col-md-6" >
            <div class="p-20">
                <div class="form-group">
                    {{ Form::label('image', 'Фото') }}
                    {!! Form::file('image', array('class' => 'general-img')) !!}
                </div>           
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
<style>
    .form-checks {
        padding-left: 20px;
        display: flex;
        justify-content: space-between;
    }

    .fileuploader {
        padding: 0;
        background: none;
    }
    .fileuploader-theme-thumbnails .fileuploader-thumbnails-input{
        margin-top: 0;
    }
            
    .fileuploader-theme-thumbnails .fileuploader-thumbnails-input, 
    .fileuploader-theme-thumbnails .fileuploader-items-list .fileuploader-item {
        width: 250px;
        height: 250px;
    }

</style>
@endsection
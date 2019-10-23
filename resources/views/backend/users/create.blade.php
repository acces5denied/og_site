@extends('backend.index') 
@section('section')
    
{!! Form::open(['url' => route('users.store'), 'class'=>'row', 'method'=>'POST','enctype'=>'multipart/form-data']) !!}
    
<div class="col-sm-12 form-row mT-10 mB-10">
    <h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
    <div class="text-right col-sm-6">
       
        {!! Html::link(route('users.index'),'Вернуться к списку',['class'=>'btn cur-p btn-secondary']) !!}
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        
    </div>
</div>

<div class="col-sm-12 mT-20">
    <div class="form-row bgc-white bd">
        <div class="col-md-6" >
            <div class="p-20">
                <div class="form-group">
                    {{ Form::label('name', 'Имя') }}
                    {{ Form::text('name', null, array('class'=>'form-control')) }}  
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {{ Form::label('email', 'E-mail') }} 
                        {{ Form::text('email', null, array('class'=>'form-control')) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('phone', 'Телефон') }} 
                        {{ Form::tel('phone', null, array('class'=>'form-control')) }}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {{ Form::label('password', 'Пароль') }}                  
                        {!! Form::password('password', array('class'=>'form-control')) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('confirm-password', 'Подтверждение пароля') }}                  
                        {!! Form::password('confirm-password', array('class'=>'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('roles', 'Роль') }}
                    {!! Form::select('roles',  $roles, null, array('class' => 'form-control', 'multiple')) !!}
                </div>           
            </div>
        </div>
        <div class="col-md-6" >
            <div class="p-20">
                <div class="form-group">
                    {{ Form::label('photo', 'Фото') }}
                    {!! Form::file('photo', array('class' => 'general-img')) !!}
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
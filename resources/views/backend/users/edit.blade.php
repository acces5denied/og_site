@extends('backend.index') 
@section('section')
    

{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id], 'class'=>'row','enctype'=>'multipart/form-data']) !!}    
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
                <div class="form-row"> 
                    <div class="form-group col-md-6">
                        {{ Form::label('name', 'Имя') }}
                        {{ Form::text('name', null, array('class'=>'form-control')) }}  
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('status', 'Статус') }}
                        {{ Form::select('status', array('active' => 'Активен', 'deactived' => 'Деактивирован'), null, array('class'=>'form-control')) }}
                    </div>
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
                    {{ Form::label('roles[]', 'Роль') }}
                    {!! Form::select('roles[]',  $roles, $userRole, array('class' => 'form-control', 'multiple')) !!}
                </div>          
            </div>
        </div>
        <div class="col-md-6" >
            <div class="p-20">
                <div class="form-group">
                    {{ Form::label('photo', 'Фото', array('style' => 'width: 100%')) }}
                    {!! Form::file('photo', array('class' => 'general-img', 'data-fileuploader-listInput' => 'general_photo', 'data-fileuploader-files' => $preLoadImg)) !!}
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
@endsection
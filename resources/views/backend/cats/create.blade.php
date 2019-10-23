@extends('backend.index') 
@section('section')
    
{!! Form::open(['url' => route('cats.store'), 'class'=>'row', 'method'=>'POST','enctype'=>'multipart/form-data']) !!}
    
<div class="col-sm-12 form-row mT-10 mB-10">
    <h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
    <div class="text-right col-sm-6">
       
        {!! Html::link(route('cats.index'),'Вернуться к списку',['class'=>'btn cur-p btn-secondary']) !!}
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        
    </div>
</div>
    
<ul class="nav nav-tabs col-sm-12 nav-main">
    <li><a  href="#tab-1" data-toggle="tab"  class="active">Основное</a></li>
    <li><a href="#tab-2" data-toggle="tab">Фото</a></li>
    <li><a href="#tab-3" data-toggle="tab">Адрес</a></li>
    <li><a href="#tab-4" data-toggle="tab">Лендинг</a></li>
    <li><a href="#tab-5" data-toggle="tab">SEO</a></li>
</ul>   

<div class="tab-content col-sm-12">
    <div class="tab-pane active" id="tab-1">
        <div class="form-row">
            <div class="col-md-6" >
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                {{ Form::label('name', 'Название') }} 
                                {{ Form::text('name', null, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('rating', 'Рейтинг') }} 
                                {{ Form::text('rating', 0, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                {{ Form::label('name_alt', 'Альтернативное название') }} 
                                {{ Form::text('name_alt', null, array('class'=>'form-control')) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" >
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                       <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('material_type', 'Тип дома') }} 
                                {!! Form::select('material_type', array('' => 'Не выбрано', 'block' => 'Блочный', 'boards' => 'Щитовой', 'brick' => 'Кирпичный', 'monolith' => 'Монолитный', 'monolithBrick' => 'Монолитно-кирпичный', 'panel' => ' Панельный', 'stalin' => 'Сталинский', 'wireframe' => 'Каркасный'), null,  array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('parking', 'Тип парковки') }} 
                                {!! Form::select('parking', array('' => 'Не выбрано', 'ground' => 'Наземная', 'multilevel' => 'Многоуровневая', 'open' => 'Открытая', 'roof' => 'На крыше', 'underground' => 'Подземная'), 'open',  array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-row">
                        	<div class="form-group col-md-6">
                                {{ Form::label('security', 'Охрана') }} 
                                {!! Form::select('security', array('' => 'Не выбрано', 'yes' => 'Да', 'no' => 'Нет'), null,  array('class' => 'form-control')) !!}
                            </div>
                        @foreach ($catpropertys as $k=>$property)
                            <div class="form-group col-md-6">
                                {{ Form::label('cat-prop-'.$k, $property) }} 
                                {{ Form::text('cat-prop-'.$k, null, array('class'=>'form-control')) }}
                            </div>
                        @endforeach
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                            {{ Form::label('Срок сдачи (для новостроек)') }} 
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('quarter', 'Квартал сдачи') }} 
                                {!! Form::select('quarter', array('' => 'Не выбрано', 'first' => 'Первый', 'second' => 'Второй', 'third' => 'Третий', 'fourth' => 'Четвертый'), null,  array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('deadline_year', 'Год сдачи') }} 
                                {{ Form::text('deadline_year', null, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group">
                               <div class="checkbox checkbox-circle checkbox-info peers mL-5">
                                   {{ Form::checkbox('is_complete', 1, false, array('class' => 'peer', 'id' => 'is_complete')) }}
                                   {{ Form::label('is_complete', 'Дом сдан') }}    
                               </div>
                            </div> 
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mT-30" >
                <div class="bgc-white p-20 bd">
                    {{ Form::label('text', 'Полное описание') }}
                    {{ Form::textarea('text', null, array('class' => 'form-control')) }}
                    
                    <div class="form-row">
                        <div class="form-group col-sm-12 mT-20">
                           	{{ Form::label('quote', 'Короткое описание') }}
                    		{{ Form::textarea('quote', null, array('class' => 'form-control')) }}
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
                            {{ Form::label('general', 'Главное изображение') }}
                            {!! Form::file('general[]', array('class' => 'general-img')) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('other', 'Галерея изображений') }}
                            {!! Form::file('other[]', array('multiple'=>true, 'class' => 'multi-img')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="tab-pane" id="tab-3">
        <div class="form-row">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-group">
                            {{ Form::label('address', 'Адрес') }} 
                            {{ Form::text('address', null, array('class'=>'form-control')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="tab-pane" id="tab-4">
        <div class="form-row">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-group">
 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="tab-pane" id="tab-5">
        <div class="form-row">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-group">
                            {{ Form::label('slug', 'ЧПУ') }}
                            {{ Form::text('slug', null, array('class'=>'form-control')) }}  
                        </div>
                        <div class="form-group">
                            {{ Form::label('seo_title', 'SEO Title') }}
                            {{ Form::text('seo_title', null, array('class'=>'form-control')) }}  
                        </div>
                        <div class="form-group">
                            {{ Form::label('seo_descr', 'SEO Description') }}
                            {{ Form::textarea('seo_descr', null, array('class'=>'form-control')) }}  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

{!! Form::close() !!}

@endsection
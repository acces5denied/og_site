@extends('backend.index') 
@section('section') 

{!! Form::open(['url' => route('cats.update',array('cat'=>$data['id'])), 'class'=>'row', 'method'=>'POST','enctype'=>'multipart/form-data']) !!} 
{!! Form::hidden('_method', 'patch') !!} 
{!! Form::hidden('id', $data['id']) !!}

<div class="col-sm-12 form-row mT-10 mB-10">
    <h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
    <div class="text-right col-sm-6">

        {!! Html::link(route('cats.index'),'Вернуться к списку',['class'=>'btn cur-p btn-secondary']) !!} {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}

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
                                {{ Form::text('name', $data['name'], array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('rating', 'Рейтинг') }} 
                                {{ Form::text('rating', $data['rating'], array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                {{ Form::label('name_alt', 'Альтернативное название') }} 
                                {{ Form::text('name_alt', $data['name_alt'], array('class'=>'form-control')) }}
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
                                {!! Form::select('material_type', array('' => 'Не выбрано', 'block' => 'Блочный', 'boards' => 'Щитовой', 'brick' => 'Кирпичный', 'monolith' => 'Монолитный', 'monolithBrick' => 'Монолитно-кирпичный', 'panel' => ' Панельный', 'stalin' => 'Сталинский', 'wireframe' => 'Каркасный'), $data['material_type'],  array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('parking', 'Тип парковки') }} 
                                {!! Form::select('parking', array('' => 'Не выбрано', 'ground' => 'Наземная', 'multilevel' => 'Многоуровневая', 'open' => 'Открытая', 'roof' => 'На крыше', 'underground' => 'Подземная'), $data['parking'],  array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-row">
                        	<div class="form-group col-md-6">
                                {{ Form::label('security', 'Охрана') }} 
                                {!! Form::select('security', array('' => 'Не выбрано', 'yes' => 'Да', 'no' => 'Нет'), $data['security'],  array('class' => 'form-control')) !!}
                            </div>
                        @foreach ($catpropertys as $k=>$property)
                            <div class="form-group col-md-6">
                                {{ Form::label('cat-prop-'.$k, $property) }} 
                                {{ Form::text('cat-prop-'.$k, (empty($old_propertys[$k]) ? null : $old_propertys[$k]), array('class'=>'form-control')) }}
                            </div>
                        @endforeach
                        </div>
                        <div class="form-row bgc-blue-100">
                            <div class="form-group col-sm-12">
                            {{ Form::label('Срок сдачи (для новостроек)') }} 
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('quarter', 'Квартал сдачи') }} 
                                {!! Form::select('quarter', array('' => 'Не выбрано', 'first' => 'Первый', 'second' => 'Второй', 'third' => 'Третий', 'fourth' => 'Четвертый'), $data['quarter'],  array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('deadline_year', 'Год сдачи') }} 
                                {{ Form::text('deadline_year', $data['deadline_year'], array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group">
                               <div class="checkbox checkbox-circle checkbox-info peers mL-5">
                                   {{Form::hidden('is_complete',0)}}
                                   {{ Form::checkbox('is_complete', 1, $data['is_complete'] ? true : false, array('class' => 'peer', 'id' => 'is_complete')) }}
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
                    {{ Form::textarea('text', $data['text'], array('class' => 'form-control')) }}
                    
                    <div class="form-row">
                        <div class="form-group col-sm-12 mT-20">
                           	{{ Form::label('quote', 'Короткое описание') }}
                    		{{ Form::textarea('quote', $data['quote'], array('class' => 'form-control')) }}
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
                            {!! Form::file('general[]', array('class' => 'general-img', 'data-fileuploader-listInput' => 'general_photo', 'data-fileuploader-files' => $preLoadImg[0])) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('other', 'Галерея изображений') }}
                            {!! Form::file('other[]', array('multiple'=>true, 'class' => 'multi-img','data-fileuploader-listInput' => 'other_photo', 'data-fileuploader-files' => $preLoadImg[1])) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="tab-pane" id="tab-3">
        <div class="form-row">
            <div class="col-md-6">
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-group">
                            {{ Form::label('address', 'Адрес') }} 
                            {{ Form::text('address', $data['address'], array('class'=>'form-control')) }}
                        </div>
                        @if (isset($cat->subway->city_subway))
                            <div class="form-group">
                                {{ Form::label('city_subway', 'Метро') }}
                                {{ Form::text('city_subway', null, array('class'=>'form-control', 'disabled', 'placeholder'=>$cat->subway->city_subway)) }}
                            </div>
                        @endif
                        @if (isset($cat->subway->city_area))
                            <div class="form-group">
                                {{ Form::label('city_area', 'Округ') }}
                                {{ Form::text('city_area', null, array('class'=>'form-control', 'disabled', 'placeholder'=>$cat->subway->city_area)) }}
                            </div>
                        @endif
                        @if (isset($cat->subway->city_district))
                            <div class="form-group">
                                {{ Form::label('city_district', 'Район') }}
                                {{ Form::text('city_district', null, array('class'=>'form-control', 'disabled', 'placeholder'=>$cat->subway->city_district)) }}
                            </div>
                        @endif
                        <div class="form-row">
                            {{ Form::label('', 'Координаты Lat/Long', array('class'=>'col-sm-12')) }}
                            <div class="form-group col-sm-6"> 
                                {{ Form::text('geo_lat', null, array('class'=>'form-control', 'disabled', 'placeholder'=>$data['geo_lat'])) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::text('geo_lon', null, array('class'=>'form-control', 'disabled', 'placeholder'=>$data['geo_lon'])) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bgc-white p-20 bd">
                    <div id="map" style="width: 100%; height: 430px"></div>
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
                            {{ Form::text('slug', $data['slug'], array('class'=>'form-control')) }}  
                        </div>
                        <div class="form-group">
                            {{ Form::label('seo_title', 'SEO Title') }}
                            {{ Form::text('seo_title', $data['seo_title'], array('class'=>'form-control')) }}  
                        </div>
                        <div class="form-group">
                            {{ Form::label('seo_descr', 'SEO Description') }}
                            {{ Form::textarea('seo_descr', $data['seo_descr'], array('class'=>'form-control')) }}  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

{!! Form::close() !!}
<style>
    [class*="ymaps-2"][class*="-ground-pane"] {
        filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
        -webkit-filter: grayscale(100%);
    }
</style>
<script>
    $(document).ready(function(){
   
        @if(isset($data['geo_lat']) && isset($data['geo_lon']))
            ymaps.ready(init);    
            function init(){ 
                var myMap = new ymaps.Map("map", {
                    center: [{{$data['geo_lat'].', '. $data['geo_lon']}}],
                    zoom: 16,
                    controls: [] // Убираем все элементы управления
                });
                myMap.behaviors.disable('scrollZoom');

                // Добавление метки
                var myPlacemark = new ymaps.Placemark([{{$data['geo_lat'].', '. $data['geo_lon']}}], {

                });

                // После того как метка была создана, добавляем её на карту.
                myMap.geoObjects.add(myPlacemark);

                ymaps.geocode(myMap.getCenter(), {

                    // Ищем только станции метро.
                    kind: 'metro',
                    // Запрашиваем не более 20 результатов.
                    results: 1
                }).then(function (res) {
                        // Задаем изображение для иконок меток.
                        res.geoObjects.options.set('preset', 'islands#redCircleIcon');
                        res.geoObjects.events
                            // При наведении на метку показываем хинт с названием станции метро.
                            .add('mouseenter', function (event) {
                                var geoObject = event.get('target');
                                myMap.hint.open(geoObject.geometry.getCoordinates(), geoObject.getPremise());
                            })
                            .add('mouseleave', function (event) {
                                myMap.hint.close(true);
                            });
                        myMap.geoObjects.add(res.geoObjects);
                    });
            }
        @endif
    });
    
    
</script>

@endsection

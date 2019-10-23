@extends('backend.index') 
@section('section') 

{!! Form::open(['url' => route('offers.update',array('offer'=>$data['id'])), 'class'=>'row', 'method'=>'POST','enctype'=>'multipart/form-data']) !!} 
{!! Form::hidden('_method', 'patch') !!} 
{!! Form::hidden('id', $data['id']) !!}

<div class="col-sm-12 form-row mT-10 mB-10">
    <h4 class="col-sm-6 c-grey-900">{{$title}}</h4>
    <div class="text-right col-sm-6">

        {!! Html::link(route('offers.index'),'Вернуться к списку',['class'=>'btn cur-p btn-secondary']) !!} 
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}

    </div>
</div>

<ul class="nav nav-tabs col-sm-12 nav-main">
    <li><a  href="#tab-1" data-toggle="tab"  class="active">Основное</a></li>
    <li><a href="#tab-2" data-toggle="tab">О ЖК</a></li>
    <li><a href="#tab-3" data-toggle="tab">Адрес</a></li>
    <li><a href="#tab-4" data-toggle="tab">Фото</a></li>
    <li><a href="#tab-5" data-toggle="tab">SEO</a></li>
    <li><a href="#tab-6" data-toggle="tab">Информация об источнике</a></li>
</ul>

<div class="tab-content col-sm-12">
    <div class="tab-pane active" id="tab-1">
        <div class="form-row">
            <div class="col-md-6" >
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                {{ Form::label('name', 'Название') }} 
                                {{ Form::text('name', $data['name'], array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('status', 'Статус') }} 
                                {!! Form::select('status', array('active' => 'Активно', 'deactived' => 'Деактивировано'), $data['status'],  array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('rating', 'Рейтинг') }} 
                                {{ Form::text('rating', $data['rating'], array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('type', 'Тип недвижимости') }}
                                {!! Form::select('type', array('' => 'Не выбрано', 'eliteflat' => 'Квартира', 'apartment' => 'Апартаменты', 'penthouse' => 'Пентхаус', 'townhouse' => 'Таунхаус'), $data['type'],  array('class' => 'form-control')) !!} 
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('finish', 'Отделка') }} 
                                {!! Form::select('finish', array('' => 'Не выбрано', 'bez-otdelki' => 'Без отделки', 's-otdelkoj' => 'С отделкой'), $data['finish'],  array('class' => 'form-control')) !!}
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-9">
                                {{ Form::label('price', 'Цена') }} 
                                {{ Form::text('price', $data['price'], array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-sm-3">
                                {{ Form::label('currency', 'Валюта') }} 
                                {!! Form::select('currency', array('RUB' => 'RUB', 'USD' => 'USD', 'EUR' => 'EUR'), $data['currency'],  array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('rooms', 'Кол-во комнат') }} 
                                {{ Form::text('rooms', $data['rooms'], array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('area', 'Площадь') }} 
                                {{ Form::text('area', $data['area'], array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('bedroom', 'Кол-во спален') }} 
                                {{ Form::text('bedroom', $data['bedroom'], array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('bathroom', 'Кол-во с/у') }} 
                                {{ Form::text('bathroom', $data['bathroom'], array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('floor', 'Этаж') }} 
                                {{ Form::text('floor', $data['floor'], array('class'=>'form-control')) }}
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
                                {{ Form::label('sale_type', 'Тип продажи') }} 
                                {!! Form::select('sale_type', array('free' => 'Свободная продажа', 'alternative' => 'Альтернатива', 'dupt' => 'Договор уступки права требования', 'dzhsk' => 'Договор ЖСК', 'fz214' => '214-ФЗ', 'investment' => 'Договор инвестирования', 'pdkp' => 'Предварительный договор купли-продажи'), $data['sale_type'],  array('class' => 'form-control')) !!}
                            </div>
                            
                            <div class="form-group col-md-6">
                                {{ Form::label('repair_type', 'Тип ремонта') }} 
                                {!! Form::select('repair_type', array('' => 'Не выбрано', 'cosmetic' => 'Косметический', 'design' => 'Дизайнерский', 'euro' => 'Евроремонт', 'no' => 'Без ремонта'), $data['repair_type'],  array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('windows_view', 'Куда выходят окна') }} 
                                {!! Form::select('windows_view', array('' => 'Не выбрано', 'street' => 'На улицу', 'yard' => 'Во двор', 'yardAndStreet' => 'На улицу и двор'), $data['windows_view'],  array('class' => 'form-control')) !!}
                            </div>
                            
                            @foreach ($offerpropertys as $k=>$property)
                                <div class="form-group col-md-6">
                                    {{ Form::label('offer-prop-'.$k, $property) }} 
                                    {{ Form::text('offer-prop-'.$k, (empty($old_propertys[$k]) ? null : $old_propertys[$k]), array('class'=>'form-control')) }}
                                </div>
                            @endforeach
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                            {{ Form::label('Настройки выгрузки') }} 
                            </div>
                            <div class="form-group col-sm-12">
                               <div class="checkbox checkbox-circle checkbox-info peers mL-5">
                                   {{Form::hidden('is_export',0)}}
                                   {{ Form::checkbox('is_export', 1, $data['is_export'] ? true : false, array('class' => 'peer', 'id' => 'is_export')) }}
                                   {{ Form::label('is_export', 'Выгружать в Cian') }}    
                               </div>
                               <div class="checkbox checkbox-circle checkbox-info peers mL-5 mT-10">
                                   {{Form::hidden('is_export_ya',0)}}
                                   {{ Form::checkbox('is_export_ya', 1, $data['is_export_ya'] ? true : false, array('class' => 'peer', 'id' => 'is_export_ya')) }}
                                   {{ Form::label('is_export_ya', 'Выгружать в Яндекс Недвижимость') }}    
                               </div>
                            </div> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('publish_terms', 'Условия размещения на ЦИАН') }} 
                                {!! Form::select('publish_terms', array('free' => 'Бесплатное', 'paid' => 'Платное', 'highlight' => 'Выделение цветом', 'premium' => 'Премиум-объявление', 'top3' => 'Топ 3'), $data['publish_terms'],  array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('bet', 'Ставка на ЦИАН') }} 
                                {{ Form::text('bet', $data['bet'], array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('text_cian', 'Заголовок объявления. Отображается только для объявлений Премиум и ТОП3. Максимальная длина - 33 символа. Минимальная - 8 символов без знаков препинания и пробелов.') }} 
                                {{ Form::text('text_cian', $data['text_cian'], array('class'=>'form-control')) }}
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
            <div class="col-md-6">
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-group">
                            {{ Form::label('cat_id', 'Выберите ЖК') }}
                            {!! Form::select('cat_id',  $category, $data['cat_id'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 disabled_group">
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
                        @foreach ($catpropertys as $k=>$property)
                            <div class="form-group col-md-6">
                                {{ Form::label('cat-prop-'.$k, $property) }} 
                                {{ Form::text('cat-prop-'.$k, (empty($old_propertys[$k]) ? null : $old_propertys[$k]), array('class'=>'form-control')) }}
                            </div>
                        @endforeach
                        </div>
                        <div class="form-row">
                        	<div class="form-group col-md-6">
                        		{!! Html::link(route('cats.edit',['cat'=>$offer->cat->id]),'Редактировать ЖК',['class'=>'btn cur-p btn-outline-primary']) !!}
							</div>
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
                        <div class="disabled_group">
                            <div class="form-group">
                                {{ Form::label('address', 'Адресс') }} 
                                {{ Form::text('address', $data['address'], array('class'=>'form-control')) }}
                            </div>
                        </div>
                        @if (isset($offer->subway->city_subway))
                            <div class="form-group">
                                {{ Form::label('city_subway', 'Метро') }}
                                {{ Form::text('city_subway', null, array('class'=>'form-control', 'disabled', 'placeholder'=>$offer->subway->city_subway)) }}
                            </div>
                        @endif
                        @if (isset($offer->subway->city_area))
                            <div class="form-group">
                                {{ Form::label('city_area', 'Округ') }}
                                {{ Form::text('city_area', null, array('class'=>'form-control', 'disabled', 'placeholder'=>$offer->subway->city_area)) }}
                            </div>
                        @endif
                        @if (isset($offer->subway->city_district))
                            <div class="form-group">
                                {{ Form::label('city_district', 'Район') }}
                                {{ Form::text('city_district', null, array('class'=>'form-control', 'disabled', 'placeholder'=>$offer->subway->city_district)) }}
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
                            {{ Form::label('general', 'Главное изображение') }}
                            {!! Form::file('general[]', array('class' => 'general-img', 'data-fileuploader-listInput' => 'general_photo', 'data-fileuploader-files' => $preLoadImg[0])) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('other', 'Галерея изображений') }}
                            {!! Form::file('other[]', array('multiple'=>true, 'class' => 'multi-img','data-fileuploader-listInput' => 'other_photo', 'data-fileuploader-files' => $preLoadImg[1])) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('plan', 'Планировки') }}
                            {!! Form::file('plan[]', array('multiple'=>true, 'class' => 'multi-img','data-fileuploader-listInput' => 'plan_photo', 'data-fileuploader-files' => $preLoadImg[2])) !!}
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
    
    <div class="tab-pane" id="tab-6">
        <div class="form-row">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('src_site', 'Сайт') }}
                                {{ Form::text('src_site', $data['src_site'], array('class'=>'form-control')) }}  
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('src_link', 'Ссылка') }}
                                {{ Form::text('src_link', $data['src_link'], array('class'=>'form-control')) }}  
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('src_tel', 'Телефон') }}
                                {{ Form::text('src_tel', $data['src_tel'], array('class'=>'form-control')) }}  
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('src_lot', '№ лота') }}
                                {{ Form::text('src_lot', $data['src_lot'], array('class'=>'form-control')) }}  
                            </div>
                            <div class="form-group col-md-12">
                                {{ Form::label('src_notice', 'Примечание') }}
                                {{ Form::textarea('src_notice', $data['src_notice'], array('class'=>'form-control')) }}  
                            </div>
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
    
    if($('#cat_id').val()){
        
       $('.disabled_group input, .disabled_group select').prop('disabled', true);
        
    };
    
    $('#cat_id').on('change', function (e) {
        var optionSelected = $('option:selected', this);
        var valueSelected = this.value;
        
        if(valueSelected){
            
            $('.disabled_group input, .disabled_group select').prop('disabled', true);
            
        }
        else{
            
            $('.disabled_group input, .disabled_group select').prop('disabled', false);

        }
        
    });
        
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

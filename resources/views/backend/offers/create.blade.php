@extends('backend.index') 
@section('section') 

{!! Form::open(['url' => route('offers.store'), 'class'=>'row', 'method'=>'POST','enctype'=>'multipart/form-data']) !!}

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
    <li><a href="#tab-3" class="hidden_link" data-toggle="tab">Адрес</a></li>
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
                            <div class="form-group col-md-6">
                                {{ Form::label('type', 'Тип недвижимости') }}
                                {!! Form::select('type', array('' => 'Не выбрано', 'eliteflat' => 'Квартира', 'apartment' => 'Апартаменты', 'penthouse' => 'Пентхаус', 'townhouse' => 'Таунхаус'), null,  array('class' => 'form-control')) !!} 
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('finish', 'Отделка') }} 
                                {!! Form::select('finish', array('' => 'Не выбрано', 'bez-otdelki' => 'Без отделки', 's-otdelkoj' => 'С отделкой'), null,  array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-9">
                                {{ Form::label('price', 'Цена') }} 
                                {{ Form::text('price', null, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-sm-3">
                                {{ Form::label('currency', 'Валюта') }} 
                                {!! Form::select('currency', array('RUB' => 'RUB', 'USD' => 'USD', 'EUR' => 'EUR'), 'rur',  array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('rooms', 'Кол-во комнат') }} 
                                {{ Form::text('rooms', null, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('area', 'Площадь') }} 
                                {{ Form::text('area', null, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('bedroom', 'Кол-во спален') }} 
                                {{ Form::text('bedroom', null, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('bathroom', 'Кол-во с/у') }} 
                                {{ Form::text('bathroom', null, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('floor', 'Этаж') }} 
                                {{ Form::text('floor', null, array('class'=>'form-control')) }}
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
                                {!! Form::select('sale_type', array('free' => 'Свободная продажа', 'alternative' => 'Альтернатива', 'dupt' => 'Договор уступки права требования', 'dzhsk' => 'Договор ЖСК', 'fz214' => '214-ФЗ', 'investment' => 'Договор инвестирования', 'pdkp' => 'Предварительный договор купли-продажи'), null,  array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('repair_type', 'Тип ремонта') }} 
                                {!! Form::select('repair_type', array('' => 'Не выбрано', 'cosmetic' => 'Косметический', 'design' => 'Дизайнерский', 'euro' => 'Евроремонт', 'no' => 'Без ремонта'), null,  array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('windows_view', 'Куда выходят окна') }} 
                                {!! Form::select('windows_view', array('' => 'Не выбрано', 'street' => 'На улицу', 'yard' => 'Во двор', 'yardAndStreet' => 'На улицу и двор'), null,  array('class' => 'form-control')) !!}
                            </div>

                            @foreach ($offerpropertys as $k=>$property)
                                <div class="form-group col-md-6">
                                    {{ Form::label('offer-prop-'.$k, $property) }} 
                                    {{ Form::text('offer-prop-'.$k, null, array('class'=>'form-control')) }}
                                </div>
                            @endforeach
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                            {{ Form::label('Настройки выгрузки') }} 
                            </div>
                            <div class="form-group col-sm-12">
                               <div class="checkbox checkbox-circle checkbox-info peers mL-5">
                                   {{ Form::checkbox('is_export', 1, false, array('class' => 'peer', 'id' => 'is_export')) }}
                                   {{ Form::label('is_export', 'Выгружать в Cian') }}    
                               </div>
                               <div class="checkbox checkbox-circle checkbox-info peers mL-5 mT-10">
                                   {{ Form::checkbox('is_export_ya', 1, false, array('class' => 'peer', 'id' => 'is_export_ya')) }}
                                   {{ Form::label('is_export_ya', 'Выгружать в Яндекс Недвижимость') }}    
                               </div>
                            </div> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('publish_terms', 'Условия размещения на ЦИАН') }} 
                                {!! Form::select('publish_terms', array('free' => 'Бесплатное', 'paid' => 'Платное', 'highlight' => 'Выделение цветом', 'premium' => 'Премиум-объявление', 'top3' => 'Топ 3'), null,  array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('bet', 'Ставка на ЦИАН') }} 
                                {{ Form::text('bet', null, array('class'=>'form-control')) }}
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('text_cian', 'Заголовок объявления. Отображается только для объявлений Премиум и ТОП3. Максимальная длина - 33 символа. Минимальная - 8 символов без знаков препинания и пробелов.') }} 
                                {{ Form::text('text_cian', null, array('class'=>'form-control')) }}
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
            <div class="col-md-6">
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-group">
                            {{ Form::label('cat_id', 'Выберите ЖК') }} 
                            {!! Form::select('cat_id', $category, null, array('class' => 'form-control')) !!}
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
                                {!! Form::select('material_type', array('' => 'Не выбрано', 'block' => 'Блочный', 'boards' => 'Щитовой', 'brick' => 'Кирпичный', 'monolith' => 'Монолитный', 'monolithBrick' => 'Монолитно-кирпичный', 'panel' => ' Панельный', 'stalin' => 'Сталинский', 'wireframe' => 'Каркасный'), null,  array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('parking', 'Тип парковки') }} 
                                {!! Form::select('parking', array('' => 'Не выбрано', 'ground' => 'Наземная', 'multilevel' => 'Многоуровневая', 'open' => 'Открытая', 'roof' => 'На крыше', 'underground' => 'Подземная'), 'open',  array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-row">
                        @foreach ($catpropertys as $k=>$property)
                            <div class="form-group col-md-6">
                                {{ Form::label('cat-prop-'.$k, $property) }} 
                                {{ Form::text('cat-prop-'.$k, null, array('class'=>'form-control')) }}
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="tab-pane" id="tab-3">
        <div class="form-row">
            <div class="col-sm-12">
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
                            {{ Form::label('general', 'Главное изображение') }}
                            {!! Form::file('general[]', array('class' => 'general-img')) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('other', 'Галерея изображений') }}
                            {!! Form::file('other[]', array('multiple'=>true, 'class' => 'multi-img')) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('plan', 'Планировки') }}
                            {!! Form::file('plan[]', array('multiple'=>true, 'class' => 'multi-img')) !!}
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
    
    <div class="tab-pane" id="tab-6">
        <div class="form-row">
            <div class="col-md-12">
                <div class="bgc-white p-20 bd">
                    <div class="mT-30">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {{ Form::label('src_site', 'Сайт') }}
                                {{ Form::text('src_site', null, array('class'=>'form-control')) }}  
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('src_link', 'Ссылка') }}
                                {{ Form::text('src_link', null, array('class'=>'form-control')) }}  
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('src_tel', 'Телефон') }}
                                {{ Form::text('src_tel', null, array('class'=>'form-control')) }}  
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('src_lot', '№ лота') }}
                                {{ Form::text('src_lot', null, array('class'=>'form-control')) }}  
                            </div>
                            <div class="form-group col-md-12">
                                {{ Form::label('src_notice', 'Примечание') }}
                                {{ Form::textarea('src_notice', null, array('class'=>'form-control')) }}  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

{!! Form::close() !!}

<script>
    $(document).ready(function() {

    $('#cat_id').on('change', function (e) {
        var optionSelected = $('option:selected', this);
        var valueSelected = this.value;
        
        if(valueSelected){
            
            $('.disabled_group input, .disabled_group select').prop('disabled', true);
            $('.hidden_link').hide();
        }
        else{
            
            $('.disabled_group input, .disabled_group select').prop('disabled', false);
            $('.hidden_link').show();
        }
        
    });

    });

</script>

@endsection

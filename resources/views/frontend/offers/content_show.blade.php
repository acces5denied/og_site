<section class="content_open">
	<div class="content_open__wrapper">
		<div class="content_open__items">
			<div class="content_open__items_item about">
				<div class="text">
					<p>{{$text[0]}}</p>
					<p class="hidden">{{$text[1]}}</p>
					@if($text[1])
						<span class="all">Показать больше</span>
					@endif
				</div>
				<div class="skills">
					<div class="prop">
						<b>Тип объекта</b> {{$offer->type_name}}
					</div>
					@if(!is_null($offer->floor))
						<div class="prop">
							<b>Этаж</b> {{$offer->floor}}
						</div>
					@endif
					@if(!is_null($offer->bedroom))
						<div class="prop">
							<b>Кол-во спален</b> {{$offer->bedroom}}
						</div>
					@endif
					@if(!is_null($offer->bathroom))
						<div class="prop">
							<b>Кол-во с/у</b> {{$offer->bathroom}}
						</div>
					@endif
				</div>
			</div>
			<div class="content_open__items_item plan">
				<div class="owl-carousel owl-plan">
					@foreach($offer->images as $image) @if($image->tag == 'plan')
					<div class="item">
						<div class="wrap">
							<div class="img" style="background-image: url({{'/images/small/' . $image->url}})" data-fancybox="plan" data-src="{{'/images/large/' . $image->url}}">
							</div>
						</div>
					</div>
					@endif @endforeach
				</div>
				<div class="tabs_content">
					<div class="itemTabOpen active">
						<div class="name">Расположение</div>
						<div class="item-content">
							<div class="itm">
								<span>Округ:<i></i></span>{{ $offer->subway->city_area }}
							</div>
							<div class="itm">
								<span>Район:<i></i></span>{{ $offer->subway->city_district }}
							</div>
							<div class="itm">
								<span>Метро:<i></i></span>{{ $offer->subway->city_subway }}
							</div>
							<div class="itm">
								<span>Адрес:<i></i></span>{{ $offer->address }}
							</div>
						</div>
					</div>
					<div class="itemTabOpen">
						<div class="name">О доме</div>
						@if($offer->cat_id)
						<div class="item-content">
							@if($offer->cat->material_type)
							<div class="itm">
								<span>Тип дома:<i></i></span> {{$offer->cat->material_type_name}}
							</div>
							@endif @if($offer->cat->security)
							<div class="itm">
								<span>Охрана:<i></i></span> {{$offer->cat->security_name}}
							</div>
							@endif @if($offer->cat->parking)
							<div class="itm">
								<span>Тип парковки:<i></i></span> {{$offer->cat->parking_name}}
							</div>
							@endif @if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 2)->first()))
							<div class="itm">
								<span>Год постройки:<i></i></span> {{$offer->cat->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value}}
							</div>
							@endif @if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 1)->first()))
							<div class="itm">
								<span>Кол-во этажей:<i></i></span> {{$offer->cat->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value}}
							</div>
							@endif @if(!is_null($offer->cat->propertys->pluck('pivot')->where('property_id', 4)->first()))
							<div class="itm">
								<span>Высота потолков:<i></i></span> {{$offer->cat->propertys->pluck('pivot')->where('property_id', 4)->first()->property_value}} м
							</div>
							@endif
						</div>
						@else
						<div class="item-content">
							@if($offer->material_type)
							<div class="itm">
								<span>Тип дома:<i></i></span> {{$offer->material_type_name}}
							</div>
							@endif @if($offer->parking)
							<div class="itm">
								<span>Тип парковки:<i></i></span> {{$offer->parking_name}}
							</div>
							@endif @if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 2)->first()))
							<div class="itm">
								<span>Год постройки:<i></i></span> {{$offer->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value}}
							</div>
							@endif @if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 1)->first()))
							<div class="itm">
								<span>Кол-во этажей:<i></i></span> {{$offer->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value}}
							</div>
							@endif @if(!is_null($offer->propertys->pluck('pivot')->where('property_id', 4)->first()))
							<div class="itm">
								<span>Высота потолков:<i></i></span> {{$offer->propertys->pluck('pivot')->where('property_id', 4)->first()->property_value}}
							</div>
							@endif
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="view_open">
	<div class="view_open__wrapper">
		<div class="view_open__items">
			<div class="view_open__items_item">
				<h2 class="title">Записаться на просмотр</h2>
				<p class="descript">Посетив персональную экскурсию, вы узнаете обо всех преимуществах и недостатках здания.</p>
				{{ Form::open(array('action' => 'FormController@callme', 'name' => 'view', 'class' => 'form')) }}
					<div class="wrap_input">
						<input type="hidden" name="subject" value="Запись на просмотр лота: {{ $offer->id }}">
						<input type="hidden" name="status" value="view">
						<span class="valid"></span>
						<input name="name" class="form-input" type="text" placeholder="ВАШЕ ИМЯ" autocomplete="off" />
					</div>
					<div class="wrap_input">
						<span class="valid"></span>
						<input name="phone" class="form-input mask" type="text" placeholder="+7 (___) ___-__-__" autocomplete="off" />
					</div>	
					<button class="btn btn-send">Записаться</button>
				{{ Form::close() }}
				<p class="alert">Нажимая на кнопку «Записаться», Вы даете согласие на обработку персональных данных в соответствии с <a href="">положением об обработке персональных данных.</a></p>
			</div>
		</div>
	</div>
</section>

<section class="map_open">
	<div class="map_open__wrapper">
		<div class="map_open__items">
			<div class="map_open__items_item title">
				<h2>Расположение на карте</h2>
			</div>
			<div class="map_open__items_item maps" id="map_open"></div>
			@if($offer->cat_id)
			@foreach($offer->cat->images as $image) @if($image->tag == 'general')
			<div class="map_open__items_item zhk" style="background-image: url({{'/images/small/' . $image->url}})">
				<h3 class="name">Жилой комплекс {{$offer->cat->name}}</h3>
				<a href="{{ route('frontend.cats.show', $offer->cat->slug) }}" target="_blank" class="btn">Подробнее<i class="icon-right-small"></i></a>
			</div>
			@endif @endforeach
			@else
			@foreach($offer->images as $image) @if($image->tag == 'general')
				<div class="map_open__items_item zhk" style="background-image: url({{'/images/small/' . $image->url}})"></div>
			@endif @endforeach
			@endif
		</div>
	</div>
</section>

{{ Form::open(array('action' => 'FormController@callme', 'name' => 'view', 'id' => 'viewing', 'class' => 'popup')) }}
	<div class="popup__items">
		<div class="popup__items_item">
			<p class="title">Назначить просмотр</p>
		</div>
		<input type="hidden" name="subject" value="Запись на просмотр лота: {{ $offer->id }}">
		<input type="hidden" name="status" value="view">
		<div class="popup__items_item input">
			<span class="valid"></span>
			<input type="text" name="name" placeholder="Имя*" autocomplete="off">
		</div>
		<div class="popup__items_item input">
			<span class="valid"></span>
			<input type="text" name="phone" placeholder="Телефон*" autocomplete="off">
		</div>
		<div class="popup__items_item person_data">
			<span>Нажимая на кнопку «Отправить», Вы даете согласие на обработку персональных данных в соответствии с</span>
			<a href="">Положением об обработке персональных данных</a>
		</div>
		<div class="popup__items_item btn_group">
			<button type="submit" class="btn btn-send">Отправить</button>
		</div>
	</div>
{{ Form::close() }}

{{ Form::open(array('action' => 'FormController@callme', 'name' => 'price_view', 'id' => 'price_view', 'class' => 'popup')) }}
	<div class="popup__items">
		<div class="popup__items_item">
			<p class="title">Узнать цену</p>
		</div>
		<input type="hidden" name="subject" value="Запрос цены лота: {{ $offer->id }}">
		<input type="hidden" name="status" value="price">
		<div class="popup__items_item input">
			<span class="valid"></span>
			<input type="text" name="name" placeholder="Имя*" autocomplete="off">
		</div>
		<div class="popup__items_item input">
			<span class="valid"></span>
			<input type="text" name="phone" placeholder="Телефон*" autocomplete="off">
		</div>
		<div class="popup__items_item person_data">
			<span>Нажимая на кнопку «Отправить», Вы даете согласие на обработку персональных данных в соответствии с</span>
			<a href="">Положением об обработке персональных данных</a>
		</div>
		<div class="popup__items_item btn_group">
			<button type="submit" class="btn btn-send">Отправить</button>
		</div>
	</div>
{{ Form::close() }}
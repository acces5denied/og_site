<section class="content_open">
	<div class="content_open__wrapper">
		<div class="content_open__items">
			<div class="content_open__items_item about">
				<div class="text">
					<p>{{$text[0]}}</p>
					<p class="hidden">{{$text[1]}}</p>
					@if($text[1])
					<span class="all">Показать больше</span> @endif
				</div>
			</div>
			<div class="content_open__items_item plan">
				<div class="tabs_content">
					<div class="itemTabOpen  active">
						<div class="name">О доме</div>
						<div class="item-content">
							@if($cat->material_type)
							<div class="itm">
								<span>Тип дома:<i></i></span> {{$cat->material_type_name}}
							</div>
							@endif @if($cat->security)
							<div class="itm">
								<span>Охрана:<i></i></span> {{$cat->security_name}}
							</div>
							@endif @if($cat->parking)
							<div class="itm">
								<span>Тип парковки:<i></i></span> {{$cat->parking_name}}
							</div>
							@endif @if(isset($cat->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value))
							<div class="itm">
								<span>Год постройки:<i></i></span> {{$cat->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value}}
							</div>
							@elseif(isset($cat->quarter))
							<div class="itm">
								<span>Год сдачи:<i></i></span> {{$cat->quarter_name}} кв. {{$cat->deadline_year}}
							</div>
							@endif @if(!is_null($cat->propertys->pluck('pivot')->where('property_id', 1)->first()))
							<div class="itm">
								<span>Кол-во этажей:<i></i></span> {{$cat->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value}}
							</div>
							@endif @if(!is_null($cat->propertys->pluck('pivot')->where('property_id', 4)->first()))
							<div class="itm">
								<span>Высота потолков:<i></i></span> {{$cat->propertys->pluck('pivot')->where('property_id', 4)->first()->property_value}} м
							</div>
							@endif @if(!is_null($cat->propertys->pluck('pivot')->where('property_id', 5)->first()))
							<div class="itm">
								<span>Кол-во пас. лифтов:<i></i></span> {{$cat->propertys->pluck('pivot')->where('property_id', 5)->first()->property_value}}
							</div>
							@endif @if(!is_null($cat->propertys->pluck('pivot')->where('property_id', 6)->first()))
							<div class="itm">
								<span>Кол-во груз. лифтов:<i></i></span> {{$cat->propertys->pluck('pivot')->where('property_id', 6)->first()->property_value}}
							</div>
							@endif @if(!is_null($cat->propertys->pluck('pivot')->where('property_id', 7)->first()))
							<div class="itm">
								<span>Растояние до метро:<i></i></span> {{$cat->propertys->pluck('pivot')->where('property_id', 7)->first()->property_value}} км.
							</div>
							@endif
						</div>
					</div>
					<div class="itemTabOpen">
						<div class="name">Расположение</div>
						<div class="item-content">
							<div class="itm">
								<span>Округ:<i></i></span>{{ $cat->subway->city_area }}
							</div>
							<div class="itm">
								<span>Район:<i></i></span>{{ $cat->subway->city_district }}
							</div>
							<div class="itm">
								<span>Метро:<i></i></span>{{ $cat->subway->city_subway }}
							</div>
							<div class="itm">
								<span>Адрес:<i></i></span>{{ $cat->address }}
							</div>
						</div>
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
					<input type="hidden" name="subject" value="Запись на просмотр ЖК: {{ $cat->id }}">
					<input type="hidden" name="status" value="view">
					<span class="valid"></span>
					<input name="name" class="form-input" type="text" placeholder="ВАШЕ ИМЯ" autocomplete="off" />
				</div>
				<div class="wrap_input">
					<span class="valid"></span>
					<input name="phone" class="form-input mask" type="text" placeholder="+7 (___) ___-__-__" autocomplete="off" />
				</div>
				<button class="btn btn-send">Записаться</button> {{ Form::close() }}
				<p class="alert">Нажимая на кнопку «Записаться», Вы даете согласие на обработку персональных данных в соответствии с <a href="">положением об обработке персональных данных.</a></p>
			</div>
		</div>
	</div>
</section>

<section class="open_offers">
	<div class="open_offers__wrapper">
		<div class="open_offers__items">
			<h2 class="open_offers__items_item title">Предложения в ЖК {{$cat->name}}</h2>
		</div>
		<div class="open_offers__items label">
			<div class="open_offers__items_item plan">Планировки</div>
			<div class="open_offers__items_item type">Тип</div>
			<div class="open_offers__items_item area">Площадь</div>
			<div class="open_offers__items_item rooms">Комнат</div>
			<div class="open_offers__items_item price">Цена</div>
			<div class="open_offers__items_item more">Описание</div>
		</div>
		@foreach($cat->offers as $offer)
		<div class="open_offers__items offer">
			<div class="open_offers__items_item plan">
			@php($flag = false)
			@forelse($offer->images as $image)
				@if($image->tag == 'plan')
					<a href="{{'/images/large/' . $image->url}}" data-fancybox="offer-{{$offer->id}}"><img src="{{ asset('assets/images/svg/planrooms.svg') }}" alt="planrooms"></a>
					@php($flag = true)
				@endif
			@empty
				<a href="" class="plan_send" data-lot="Запрос планировки лота: {{$offer->id}}" data-fancybox data-src="#planirovka"><img src="{{ asset('assets/images/svg/planrooms.svg') }}" alt="planrooms"></a>
			@endforelse

			@if($flag == false && $offer->images->isNotEmpty())
				<a href="" class="plan_send" data-lot="Запрос планировки лота: {{$offer->id}}" data-fancybox data-src="#planirovka"><img src="{{ asset('assets/images/svg/planrooms.svg') }}" alt="planrooms"></a>
			@endif
			</div>
			<div class="open_offers__items_item type">{{ $offer->type_name }}</div>
			<div class="open_offers__items_item area">{{ $offer->area }}</div>
			<div class="open_offers__items_item rooms">{{ $offer->rooms }}</div>
			<div class="open_offers__items_item price">
				@if($offer->price_in_rub == 0)
					По запросу
				@else
					{{ number_format($offer->price_in_rub, 0, '', ' ') }}  ₽
				@endif
			</div>
			<div class="open_offers__items_item more"><a href="{{ route('frontend.offers.show', $offer->slug) }}" target="_blank">Подробнее</a></div>
		</div>	
		@endforeach
		<div class="open_offers__items">
			<div class="open_offers__items_item button">
				<label for="all_offers" class="btn" id="show_all"><span>Показать еще</span><input type="checkbox" id="all_offers"></label>
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
			@foreach($cat->images as $image) @if($image->tag == 'general')
				<div class="map_open__items_item zhk" style="background-image: url({{'/images/small/' . $image->url}})"></div>
			@endif @endforeach
		</div>
	</div>
</section>




{{ Form::open(array('action' => 'FormController@plan', 'name' => 'plan', 'id' => 'planirovka', 'class' => 'popup')) }}
	<div class="popup__items">
		<div class="popup__items_item">
			<p class="title">Запросить планировку</p>
		</div>
		<input type="hidden" name="subject" value="Запрос планировки лота: ">
		<input type="hidden" name="status" value="plan">
		<div class="popup__items_item input">
			<span class="valid"></span>
			<input type="text" name="name" placeholder="Имя*" autocomplete="off">
		</div>
		<div class="popup__items_item input">
			<span class="valid"></span>
			<input type="text" name="phone" placeholder="Телефон*" autocomplete="off">
		</div>
		<div class="popup__items_item input">
			<span class="valid"></span>
			<input type="text" name="email" placeholder="E-mail*" autocomplete="off">
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

{{ Form::open(array('action' => 'FormController@callme', 'name' => 'view', 'id' => 'viewing', 'class' => 'popup')) }}
	<div class="popup__items">
		<div class="popup__items_item">
			<p class="title">Назначить просмотр</p>
		</div>
		<input type="hidden" name="subject" value="Запись на просмотр ЖК: {{ $cat->id }}">
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

<section class="header_open">
	<div class="header_open__wrapper">
		<div class="header_open__items">
			<div class="header_open__items_item">
				{{ Breadcrumbs::render('cat', $cat) }}
				<h1 class="title">{{$cat->name}}</h1>
				<div class="block_down">
					<div class="block_address">
						<a href="#map_open"><i class="icon-location"></i>Смотреть на карте</a>
						<span>{{$cat->address}}</span>
					</div>
					<span class="lot">ID: <b>{{$cat->id}}</b></span>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="slider_open">
	<div class="block_slider">
		<div class="slider_open__wrapper">
			<div class="slider_open__items">
				<div class="slider_open__items_item">
					<div class="owl-carousel owl-open">
						@foreach($cat->images as $image) @if($image->tag != 'plan')
						<div class="item">
							<div class="wrap">
								<div class="img" style="background-image: url({{'/images/large/' . $image->url}});">
									<a href="{{'/images/large/' . $image->url}}" data-fancybox="images"></a>
								</div>
							</div>
						</div>
						@endif @endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="slider_open__wrapper propertys">
		<div class="slider_open__items items">
			<div class="slider_open__items_item property">
				
				@if (isset($cat->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value))
				<div class="prop">
					Построен
					<b>{{$cat->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value}} г.</b>
				</div>
				@elseif (isset($cat->quarter))
				<div class="prop">
					Год постройки
					<b>{{$cat->quarter_name}} кв. {{$cat->deadline_year}} г.</b>
				</div>
				@endif
				
				@if (isset($cat->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value))
				<div class="prop">
					Этажей
					<b>{{$cat->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value}}</b>
				</div>
				@endif

				<div class="prop">
					Площадь <b>от {{$cat->offers->min('area')}}м²</b>
				</div>

			</div>
			<div class="slider_open__items_item property down">
				<div class="price">
					@if($cat->offers->max('price_in_rub') == 0)
						<span class="wrap" id="price_open">
							<i>Цена</i>
							<b class="active">По запросу</b>
						</span>
					@else 
						<span class="wrap" id="price_open">
							<i>Цена</i> 
							<b class="rub active">от {{number_format($cat->offers->filter(function ($value) {
								return $value->price_in_rub > 0;
							})->min('price_in_rub'), 0, '', ' ')}}</b>
							<b class="usd">от {{number_format($cat->offers->filter(function ($value) {
								return $value->price_in_rub > 0;
							})->min('price_in_usd'), 0, '', ' ')}}</b>
							<b class="eur">от {{number_format($cat->offers->filter(function ($value) {
								return $value->price_in_rub > 0;
							})->min('price_in_eur'), 0, '', ' ')}}</b>
						</span>
						<select class="currency" name="currency" id="currency_open">
						   <option value="rub" data-txt='₽' selected="selected">₽</option>
						   <option value="usd" data-txt='$'>$</option>
						   <option value="eur" data-txt='€'>€</option>
						</select>
					@endif
				</div>
				<button class="btn" data-fancybox data-src="#viewing">Назначить просмотр</button>
			</div>
		</div>
	</div>
</section>
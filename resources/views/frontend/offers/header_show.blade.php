<section class="header_open">
	<div class="header_open__wrapper">
		<div class="header_open__items">
			<div class="header_open__items_item">
				{{ Breadcrumbs::render('offer', $offer) }}
				<h1 class="title">{{$offer->name}}</h1>
				<div class="block_down">
					<div class="block_address">
						<a href="#map_open"><i class="icon-location"></i>Смотреть на карте</a>
						<span>{{$offer->address}}</span>
					</div>
					<span class="lot">ID: <b>{{$offer->id}}</b></span>
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
						@foreach($offer->images as $image) @if($image->tag != 'plan')
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
				<div class="prop">
					Площадь <b>{{$offer->area}}м²</b>
				</div>
				<div class="prop">
					Комнат <b>{{$offer->rooms}}</b>
				</div>
				<div class="prop">
					Отделка <b>{{$offer->finish == 's-otdelkoj' ? 'Есть' : 'Нет'}}</b>
				</div>
			</div>
			@if($offer->price_in_rub == 0)
				<div class="slider_open__items_item property down">
					<div class="price">
						<span class="wrap">
							<i>Цена</i>
							<b class="active">По запросу</b>
						</span>
					</div>
					<button class="btn" data-fancybox data-src="#price_view">Запросить цену</button>
				</div>
			@else
				<div class="slider_open__items_item property down">
					<div class="price">
						<span class="wrap" id="price_open">
						<i>Цена</i>
							<b class="rub active">{{number_format($offer->price_in_rub, 0, '', ' ')}}</b>
							<b class="usd">{{number_format($offer->price_in_usd, 0, '', ' ')}}</b>
							<b class="eur">{{number_format($offer->price_in_eur, 0, '', ' ')}}</b>
						</span>
						<select class="currency" name="currency" id="currency_open">
							<option value="rub" data-txt='₽' selected="selected">₽</option>
							<option value="usd" data-txt='$'>$</option>
							<option value="eur" data-txt='€'>€</option>
						</select>
					</div>
					<button class="btn" data-fancybox data-src="#viewing">Назначить просмотр</button>
				</div>
			@endif
		</div>
	</div>
</section>

@if($similar->count() > 2)
<section class="new_open">
	<div class="new_open__wrapper">
		<div class="new_open__items">
			<div class="new_open__items_item title">
				<p>Похожие ЖК</p>
			</div>
		</div>
		<div class="new_open__items">
			<div class="new_open__items_item">

				<div class="owl-carousel owl-new similar">
					@foreach($similar as $item)
					<a href="{{ route('frontend.cats.show', $item->slug) }}" class="item" target="_blank">
						<div class="top">
							<h4 class="title">{{$item->name}}</h4>
							<span class="address">{{$item->address}}</span>
						</div>
						<div class="center">
							<div class="wrap">
								@foreach($item->images as $image) @if($image->tag == 'general')
								<div class="img" style="background-image: url({{'/images/small/' . $image->url}})"></div>
								@endif @endforeach
							</div>
						</div>
						<span class="price">
						
							@if($item->offers->max('price_in_rub') == 0)
								По запросу
							@else   		
								от {{number_format($item->offers->filter(function ($value) {
									return $value->price_in_rub > 0;
								})->min('price_in_rub'), 0, '', ' ')}}

								@if($item->offers->filter(function ($value) {
									return $value->price_in_rub > 0;
								})->min('price_in_rub') != $item->offers->max('price_in_rub'))
									<br> 
									до {{number_format($item->offers->max('price_in_rub'), 0, '', ' ')}}
								@endif
								₽
							@endif
						</span>
					</a>
					@endforeach
				</div>

			</div>
		</div>
		@if($cat->subway->infr)
		<div class="new_open__items">
			<div class="new_open__items_item title">
				<p class="subway">Инфраструктура</p>
			</div>
		</div>
		<div class="new_open__items">
			<div class="new_open__items_item descript">
				<p>{{$cat->subway->infr}}</p>
			</div>
		</div>
		@endif
	</div>
</section>
@endif
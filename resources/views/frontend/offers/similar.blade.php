@if($similar->count() > 2)
<section class="new_open">
	<div class="new_open__wrapper">
		<div class="new_open__items">
			<div class="new_open__items_item title">
				<p>Похожие объекты</p>
			</div>
		</div>
		<div class="new_open__items">
			<div class="new_open__items_item">

				<div class="owl-carousel owl-new similar">
					@foreach($similar as $item)
					<a href="{{ route('frontend.offers.show', $item->slug) }}" class="item" target="_blank">
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
						<div class="bottom">
							<div class="skills">
								<span><img src="{{ asset('assets/images/svg/area.svg') }}" alt="">{{$item->area}} м²</span>
								<span><img src="{{ asset('assets/images/svg/planrooms.svg') }}" alt="">{{$item->rooms}} комнаты</span>
							</div>
						</div>
						<span class="price">
							@if($item->price_in_rub == 0)
								По запросу
							@else
								{{$item->price_in_rub}} ₽
							@endif
						</span>
					</a>
					@endforeach
				</div>

			</div>
		</div>
		@if($offer->subway->infr)
		<div class="new_open__items">
			<div class="new_open__items_item title">
				<p class="subway">Инфраструктура</p>
			</div>
		</div>
		<div class="new_open__items">
			<div class="new_open__items_item descript">
				<p>{{$offer->subway->infr}}</p>
			</div>
		</div>
		@endif
	</div>
</section>
@endif
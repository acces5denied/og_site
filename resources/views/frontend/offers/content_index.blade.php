<section class="offers">
	<div class="offers__wrapper">
	
		<div class="offers__items control">
			<div class="offers__items_item counter">
				Найдено {{$offers->total()}}
				@if($offers->total() == 1)
					объект
				@elseif($offers->total() <= 5)
					объекта
				@else
					объектов
				@endif
			</div>
			<div class="offers__items_item block2">
				<div class="row">
					<div class="sort">
						<label for="sort">Сортировка</label>
						<select class="form-control count sortingeven" id="sort" name="sort">
                            <option value="{{ Request::fullUrlWithQuery(['sort' => 'id', 'sort_type' => 'desc']) }}" data-txt='По умолчанию' {{$sort_data == 'id' ? 'selected' : ''}}>По умолчанию</option>
                            <option value="{{ Request::fullUrlWithQuery(['sort' => 'rating', 'sort_type' => 'desc']) }}" data-txt='По рейтингу' {{$sort_data == 'rating' ? 'selected' : ''}}>По рейтингу</option>
                            <option value="{{ Request::fullUrlWithQuery(['sort' => 'price_in_rub', 'sort_type' => 'desc']) }}" data-txt='По цене <i class="icon-sort-alt-down"></i>' {{$sort_data == 'price_in_rub' &&  $sort_type_data == 'desc'? 'selected' : ''}}>По цене</option>
                            <option value="{{ Request::fullUrlWithQuery(['sort' => 'price_in_rub', 'sort_type' => 'asc']) }}" data-txt='По цене <i class="icon-sort-alt-up"></i>' {{$sort_data == 'price_in_rub' &&  $sort_type_data == 'asc'? 'selected' : ''}}>По цене</option>
                            <option value="{{ Request::fullUrlWithQuery(['sort' => 'area', 'sort_type' => 'desc']) }}" data-txt='По площади <i class="icon-sort-alt-down"></i>' {{$sort_data == 'area' &&  $sort_type_data == 'desc'? 'selected' : ''}}>По площади</option>
                            <option value="{{ Request::fullUrlWithQuery(['sort' => 'area', 'sort_type' => 'asc']) }}" data-txt='По площади <i class="icon-sort-alt-up"></i>' {{$sort_data == 'area' &&  $sort_type_data == 'asc'? 'selected' : ''}}>По площади</option>
                       </select>
					</div>
					<div class="show_page">
						<label for="">Выводить</label>
						<div class="show_page_wrap">
							<a href="{{ Request::fullUrlWithQuery(['paginate' => '20']) }}" class=" {{$paginate_data == '20' ? 'active' : ''}}">20</a>
							<a href="{{ Request::fullUrlWithQuery(['paginate' => '40']) }}" class=" {{$paginate_data == '40' ? 'active' : ''}}">40</a>
							<a href="{{ Request::fullUrlWithQuery(['paginate' => '60']) }}" class=" {{$paginate_data == '60' ? 'active' : ''}}">60</a>
						</div>
					</div>
				</div>

			</div>
		</div>
		
	@if($offers->total() > 0)
		<div class="offers__items">
			@foreach($offers as $offer)
			<div class="offers__items_item  offer">
				<div class="wrap">
					<div class="content hidden-pc">
						<div class="top_block">
							<span class="address"><i class="icon-location"></i>
								@if(isset($offer->subway->city_subway)) 
									м. {{ $offer->subway->city_subway }}, 
								@endif
								{{ $offer->address }}
							</span>
							<h2>{{ $offer->name }}</h2>
						</div>
					</div>
					<div class="image">
						@foreach($offer->images as $image) 
                           @if($image->tag == 'general')
                               <img src="{{ '/images/small/' . $image->url }}" alt="{{ $offer->name }}">
                           @endif
                        @endforeach
					</div>
					<div class="content">
						<div class="top_block hidden-mob">
							<p>
								<span class="address"><i class="icon-location"></i>
									@if(isset($offer->subway->city_subway)) 
										м. {{ $offer->subway->city_subway }}, 
									@endif
									{{ $offer->address }}
								</span>
								<span class="id">ID: <b>{{ $offer->id }}</b></span>
							</p>
							<h2>{{ $offer->name }}</h2>
						</div>
						<div class="down_block">
							<div class="tth">
								<div class="skills">
									@if (isset($offer->area))
										<span><img src="{{ asset('assets/images/svg/area.svg') }}" alt="">{{ $offer->area }} м²</span>
									@endif
									@if (isset($offer->rooms))
										<span>
											<img src="{{ asset('assets/images/svg/planrooms.svg') }}" alt="">
											{{ $offer->rooms }}
											@if ($offer->rooms == 1 )
												комната
											@elseif (($offer->rooms > 1)&&($offer->rooms < 5))
												комнаты
											@else
												комнат
											@endif
										</span>
									@endif
									@if (!is_null($offer->propertys->pluck('pivot')->where('property_id', 8)->first()))
									<span>
										<img src="{{ asset('assets/images/svg/stairs.svg') }}" alt="">
										{{ $offer->propertys->pluck('pivot')->where('property_id', 8)->first()->property_value }}
										этаж
									</span>
									@endif
									@if (isset($offer->finish))
										<span><img src="{{ asset('assets/images/svg/finish.svg') }}" alt="">{{ $offer->finish_name }}</span>
									@endif
								</div>
								@if (isset($offer->quote))
									<p class="descr">{!! $offer->quote !!}</p>
								@endif
							</div>
							<div class="price">
								@if($offer->price_in_rub == 0)
									<span>По запросу</span>
								@else
									@if($currency_data == 'USD')
									<span>{{ number_format($offer->price_in_usd, 0, '', ' ') }}  $</span>
									@elseif($currency_data == 'EUR')
									<span>{{ number_format($offer->price_in_eur, 0, '', ' ') }}  €</span>
									@else
									<span>{{ number_format($offer->price_in_rub, 0, '', ' ') }}  ₽</span>
									@endif
								@endif
								<a href="{{ route('frontend.offers.show', $offer->slug) }}" target="_blank" class="btn">Подробнее</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	@else

		<p>Предложений не найдено</p>

	@endif
		
	</div>
</section>

{{ $offers->appends(request()->input())->links('vendor.pagination.pagination') }}

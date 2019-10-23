<section class="offers">
	<div class="offers__wrapper">
	
		<div class="offers__items control">
			<div class="offers__items_item counter">Найдено {{$cats->total()}} ЖК</div>
			<div class="offers__items_item block2">
				<div class="row">
					<div class="sort">
						<label for="sort">Сортировка</label>
						<select class="form-control count sortingeven" id="sort" name="sort">
                            <option value="{{ Request::fullUrlWithQuery(['sort' => 'id', 'sort_type' => 'asc']) }}" data-txt='По умолчанию' {{$sort_data == 'id' ? 'selected' : ''}}>По умолчанию</option>
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
		
	@if($cats->total() > 0)
		<div class="offers__items">
			@foreach($cats as $cat)
			<div class="offers__items_item  cat">
				<div class="wrap">
					<div class="content hidden-pc">
						<div class="top_block">
							<span class="address"><i class="icon-location"></i>
								@if(isset($cat->subway->city_subway)) 
									м. {{ $cat->subway->city_subway }}, 
								@endif
								{{ $cat->address }}
							</span>
							<h2>{{ $cat->name }}</h2>
						</div>
					</div>
					<div class="image">
						@foreach($cat->images as $image) 
                           @if($image->tag == 'general')
                               <img src="{{ '/images/small/' . $image->url }}" alt="{{ $cat->name }}">
                           @endif
                        @endforeach
					</div>
					<div class="content">
						<div class="top_block hidden-mob">
							<p>
								<span class="address"><i class="icon-location"></i>
									@if(isset($cat->subway->city_subway)) 
										м. {{ $cat->subway->city_subway }}, 
									@endif
									{{ $cat->address }}
								</span>
								<span class="id">ID: <b>{{ $cat->id }}</b></span>
							</p>
							<h2>{{ $cat->name }}</h2>
						</div>
						<div class="down_block">
							<div class="wrap_item">
							@foreach($cat->offers as $k=>$offer)

								@if ($k>2)
									@break
								@endif
								
								<ul class="item">
									<li>{{ $offer->type_name }}</li>
									<li>{{ $offer->area }} м²</li>
									<li>
									{{ $offer->rooms }}

										@if ($offer->rooms == 1 )
											комната
										@elseif (($offer->rooms > 1)&&($offer->rooms < 5))
											комнаты
										@else
											комнат
										@endif
									</li>
							    	@if (isset($offer->finish))
								    <li>
										{{$offer->finish_name}}
									</li>
									@endif
									
									<li>
									@if($offer->price_in_rub == 0)
										По запросу
									@else
										@if($currency_data == 'USD')
											{{ number_format($offer->price_in_usd, 0, '', ' ') }}  $
										@elseif($currency_data == 'EUR')
											{{ number_format($offer->price_in_eur, 0, '', ' ') }}  €
										@else
											{{ number_format($offer->price_in_rub, 0, '', ' ') }}  ₽
										@endif
									@endif
									</li>
								</ul>		
							@endforeach
							</div>
							<div class="tth">
								<div class="skills">
									@if (isset($cat->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value))
										<span><img src="{{ asset('assets/images/svg/calendar.svg') }}" alt="">{{$cat->propertys->pluck('pivot')->where('property_id', 2)->first()->property_value}} г.</span>
									@elseif (isset($cat->quarter))
										<span><img src="{{ asset('assets/images/svg/calendar.svg') }}" alt="">{{$cat->quarter_name}} кв. {{$cat->deadline_year}} г.</span>
									@endif
									
									<span>
										<img src="{{ asset('assets/images/svg/area.svg') }}" alt="">
										{{ $cat->offers->min('area') }}
								   		@if($cat->offers->min('area') != $cat->offers->max('area'))
									 		- {{ $cat->offers->max('area') }}
								   		@endif
								   		м²
									</span>

									@if (isset($cat->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value))
									   <span><img src="{{ asset('assets/images/svg/stairs.svg') }}" alt="">{{$cat->propertys->pluck('pivot')->where('property_id', 1)->first()->property_value}}</span>
									@endif
									
									@if (isset($cat->parking))
										<span><img src="{{ asset('assets/images/svg/parking.svg') }}" alt="">{{$cat->parking_name}}</span>
									@endif
								</div>
							</div>
							<div class="btn_wrap">
								<a href="{{ route('frontend.cats.show', $cat->slug) }}" class="btn" target="_blank">{{ $cat->offers->count() }} 
								@if($cat->offers->count() == 1)
									предложение
								@elseif($cat->offers->count() >= 5)
									предложений
								@else
									предложения
								@endif
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	@else

		<p>Жилищных комплексов не найдено</p>

	@endif
		
	</div>
</section>

{{ $cats->appends(request()->input())->links('vendor.pagination.pagination') }}
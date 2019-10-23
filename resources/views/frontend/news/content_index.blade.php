<section class="news_block">
	<div class="news_block__wrapper">
		<div class="news_block__items control">
			<div class="news_block__items_item counter">
				Найдено {{$news_count->count()}}
				@if($news_count->count() == 1)
					статья
				@elseif($news_count->count() <= 5)
					статьи
				@else
					статей
				@endif
			</div>
			<div class="news_block__items_item block2">
				<div class="row">
					<div class="sort">
						<label for="sort">Сортировка</label>
						<select class="form-control count sortingeven" id="sort" name="sort">
								<option value="{{ Request::fullUrlWithQuery(['sort' => 'id', 'sort_type' => 'asc']) }}" data-txt='По умолчанию' {{$sort_data == 'id' ? 'selected' : ''}}>По умолчанию</option>
								<option value="{{ Request::fullUrlWithQuery(['sort' => 'created_at', 'sort_type' => 'desc']) }}" data-txt='По дате <i class="icon-sort-alt-down"></i>' {{$sort_data == 'created_at' &&  $sort_type_data == 'desc'? 'selected' : ''}}>По дате</option>
								<option value="{{ Request::fullUrlWithQuery(['sort' => 'created_at', 'sort_type' => 'asc']) }}" data-txt='По дате <i class="icon-sort-alt-up"></i>' {{$sort_data == 'created_at' &&  $sort_type_data == 'asc'? 'selected' : ''}}>По дате</option>
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
		
		@if($news->count() > 0)
		<div class="news_block__items">
		@foreach($news as $item)
		@if($item->is_top)
			<div class="news_block__items_item news_top">
				<div class="wrap">
					<div class="image">
						<img src="{{ '/images/small/' . $item->image }}" alt="{{$item->name}}">
					</div>
					<div class="content">
						<h2 class="title">{{$item->name}}</h2>
						<p class="descript">{{$item->quote}}</p>
						<a href="{{ route('frontend.news.show', $item->slug) }}" class="link" target="_blank">Читать</a>
					</div>
				</div>
			</div>
			@break
		@endif
		@endforeach
		</div>

		<div class="news_block__items">
			<div class="news_block__items_item item_wrap">
			@foreach($news as $item)
			@if($item->is_top)
				@continue
			@endif
				<div class="item">
					<h2 class="title">{{$item->name}}</h2>
					<p class="descript">{{$item->quote}}</p>
					<a href="{{ route('frontend.news.show', $item->slug) }}" class="link" target="_blank">Читать</a>
				</div>
			@endforeach
			</div>
			<div class="news_block__items_item sidebar">
				<aside>
					<p class="title">Последние новости</p>
					@foreach($news as $k=>$item)
						
						@if($item->is_top)
							@php($k = $k-1)
							@continue
						@endif
						@if ($k>5)
							@break
						@endif
						<a href="{{ route('frontend.news.show', $item->slug) }}" class="last" target="_blank">
							<h3>{{$item->name}}</h3>
							<span class="data">{{$item->created_at->format('d.m.Y')}}</span>
						</a>
					@endforeach
				</aside>
			</div>
		</div>
		@else

		<p>Статей не найдено</p>

		@endif
		
	</div>
</section>

{{ $news->appends(request()->input())->links('vendor.pagination.pagination') }}
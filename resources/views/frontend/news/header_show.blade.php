<section class="header_open">
	<div class="header_open__wrapper">
		<div class="header_open__items">
			<div class="header_open__items_item">
				{{ Breadcrumbs::render('news_open', $news) }}
				<h1 class="title">{{$news->name}}</h1>
			</div>
		</div>
	</div>
</section>
<section class="news_open">
	<div class="news_open__wrapper">
		<div class="news_open__items">
			<div class="news_open__items_item">
				<div class="wrap">
					<img src="{{'/images/large/' . $news->image}}" alt="{{$news->name}}">
				</div>
			</div>
		</div>
	</div>
</section>

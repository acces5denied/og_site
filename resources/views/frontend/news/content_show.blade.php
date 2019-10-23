<section class="news_content">
	<div class="news_content__wrapper">
		<div class="news_content__items">
			<div class="news_content__items_item data">
				{{$news->created_at->format('d.m.Y')}}
			</div>
			<div class="news_content__items_item text">
				{!!$news->text!!}
			</div>
		</div>
	</div>
</section>

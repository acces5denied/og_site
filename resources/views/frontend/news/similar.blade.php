@if($similar->count() > 2)
<section class="news">
	<div class="news__wrapper">
		<div class="news__items">
			<div class="news__items_item title">
				<h2>Другие новости</h2>
			</div>
		</div>
		<div class="news__items">
			<div class="news__items_item">
				<div class="owl-carousel owl-new">
					@foreach($similar as $item)
					<a href="{{ route('frontend.news.show', $item->slug) }}" class="item">
						<div class="wrap">
							<div class="img" style="background-image: url({{'/images/small/' . $item->image}})">
								<span class="data">{{$item->created_at->format('d.m.Y')}}</span>
								<p class="title">{{$item->name}}</p>
							</div>
						</div>
					</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</section>
@endif
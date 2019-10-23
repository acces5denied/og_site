@if ($paginator->hasPages())
<section class="pagination">
	<div class="pagination__wrapper">
		<div class="pagination__items">
			<ul class="pagination__items_item" role="navigation">


				{{-- Pagination Elements --}}
				@foreach ($elements as $element)
					{{-- "Three Dots" Separator --}}
					@if (is_string($element))
						<li class="page-item" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
					@endif

					{{-- Array Of Links --}}
					@if (is_array($element))
						@foreach ($element as $page => $url)
							@if ($page == $paginator->currentPage())
								<li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
							@else
								<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
							@endif
						@endforeach
					@endif
				@endforeach

			</ul>
		</div>
	</div>
</section>
    
@endif


<nav class="nav_mobile mob_menu">
    @if(URL::current() == url('/'))
    	<img src="{{ asset('assets/images/logo.png') }}" alt="OGHome">
    @else
    	<a href="/"><img src="{{ asset('assets/images/logo.png') }}" alt="OGHome"></a>
    @endif
    <ul>
        @foreach($menu as $item)
        	@if($item['url'] === Request::url())
        		<li class="active">{{ $item['title'] }}</li>
        	@else
        		<li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
        	@endif
		@endforeach
    </ul>
</nav>

<nav class="nav {{ (URL::current() == url('/')) ? 'home' : '' }} mob_menu nav_fixed">
    <div class="nav__wrapper">
        <div class="nav__items">
            <div class="nav__items_item logo">
                @if(URL::current() === url('/'))
					<img src="{{ asset('assets/images/logo.png') }}" alt="OGHome">
				@else
					<a href="/"><img src="{{ asset('assets/images/logo.png') }}" alt="OGHome"></a>
				@endif
            </div>
            <ul class="nav__items_item">
                @foreach($menu as $item)
					@if($item['url'] == Request::url())
						<li class="active">{{ $item['title'] }}</li>
					@else
						<li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
					@endif
				@endforeach
            </ul>
            <a href="" rel="nofollow" class="nav__items_item phone">+7 (495) 154 12 32</a>
            <div class="nav__items_item mobil_group">
                <a href="javascript:;" rel="nofollow" data-fancybox data-src="#callme"><img src="{{ asset('assets/images/svg/phone-call.svg') }}" alt="phone"></a>
                <div class="button">
                    <input type="checkbox" id="checkbox" class="checkbox visuallyHidden">
                    <label for="checkbox">
                        <div class="hamburger">
                            <span class="bar bar1"></span>
                            <span class="bar bar2"></span>
                            <span class="bar bar3"></span>
                            <span class="bar bar4"></span>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</nav>

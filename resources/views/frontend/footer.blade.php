 <footer class="footer">
    <div class="footer__wrapper">
        <div class="footer__items footer-tabs-content">
            <ul class="footer__items_item tabs-nav">
			@foreach($offers->unique('type') as $k=>$offer)
				<li>
					<a href="#{{$offer->type}}" rel="nofollow" class="{{$k == 0?'active':''}}">{{$offer->type_name}}</a>
				</li>
			@endforeach
			</ul>
            
            @foreach($offers->unique('type') as $k=>$offer)
			<div id="{{$offer->type}}" class="footer__items_item itemTab {{ $k == 0 ? 'active' : '' }}">
                <div class="name">{{$offer->type_name}}</div>
                <div class="item-content">
                    <div class="half">
                        <span class="label">Метро</span>
                        <ul class="li-items">
                            @foreach($offers->sortBy('subway.city_subway')->where('type', $offer->type)->unique('subway_id') as $offer)
								<li>
								@if($_SERVER['REQUEST_URI'] == '/city/' . $offer->type . '/' . $offer->subway->slug_subway)
									{{$offer->subway->city_subway}}
								@else
									<a href="{{ '/city/' . $offer->type . '/' . $offer->subway->slug_subway }}">{{$offer->subway->city_subway}}</a>
								@endif
								</li>
                            @endforeach 
                        </ul>
                        <span class="show-hide-btn">Смотреть все<i class="icon-right-small"></i></span>
                    </div>

                    <div class="half">
                        <span class="label">Район</span>
                        <ul class="li-items">
                            @foreach($offers->sortBy('subway.city_district')->where('type', $offer->type)->unique('subway.city_district') as $offer)
                            	<li>
                            		<a href="{{ '/city/' . $offer->type . '/' . $offer->subway->slug_district }}">{{$offer->subway->city_district}}</a>
                            	</li>
                            @endforeach
                        </ul>
                        <span class="show-hide-btn">Смотреть все<i class="icon-right-small"></i></span>
                    </div>
                </div>
            </div>
			@endforeach
        </div>

        <div class="footer__items contacts">
            <div class="footer__items_item contact">
                <div class="phone">
                    <a href="">+7 (495) 142-32-21</a>
                    <button class="btn" data-fancybox data-src="#callme">Позвонить мне</button>
                </div>
            </div>
            <div class="footer__items_item mail">
                <span class="title">Получать интересные предложения</span>
                {{ Form::open(array('action' => 'FormController@subscribe', 'name' => 'subscribe', 'class' => 'form')) }}
                    <div class="form-group">
                        <label class="form-label" for="first">Ваш E-mail</label>
                        <span class="success">Спасибо, Вы подписанны!</span>
                        <span class="valid"></span>
                        <input type="hidden" name="subject" value="Подписка на рассылку">
                        <input type="hidden" name="status" value="subscribe">
                        <input class="form-input" type="text" name="email" autocomplete="off" />
                    </div>
                    <button type="submit" class="btn btn-send">Подписаться<i class="icon-right-small"></i></button>
                {{ Form::close() }}
            </div>
        </div>
        <div class="footer__items">
            <div class="footer__items_item confedencial">
                Настоящим информируем вас о том, что вся информация, размещенная на данном сайте, ни при каких обстоятельствах не может признаваться публичной офертой в соответствии со ст. 437.2 Гражданского кодекса РФ. Копирование и воспроизведение материалов этого сайта возможно с согласия администрации сайта. Посещая сайт, вы даете согласие на обработку данных cookies и иных пользовательских данных.
            </div>
        </div>
    </div>
</footer>

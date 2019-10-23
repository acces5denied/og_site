<section class="home_block">
    <div class="home_block__wrapper">
        <div class="home_block__items">
            <a href="city/eliteflat/" class="home_block__items_item">
                <img src="{{ asset('assets/images/svg/eliteflat.svg') }}" alt="eliteflat">
                <span>Квартиры</span>
            </a>
            <a href="city/apartment/" class="home_block__items_item">
                <img src="{{ asset('assets/images/svg/skyscraper.svg') }}" alt="apartment">
                <span>Апартаменты</span>
            </a>
            <a href="city/penthouse/" class="home_block__items_item">
                <img src="{{ asset('assets/images/svg/penthause.svg') }}" alt="penthause">
                <span>Пентхаусы</span>
            </a>
            <a href="city/townhouse/" class="home_block__items_item">
                <img src="{{ asset('assets/images/svg/tounhouse.svg') }}" alt="townhouse">
                <span>Таунхаусы</span>
            </a>
        </div>
    </div>
</section>

@if(isset($banners) && ($banners->count() > 0))
<section class="home_slider">
    <div class="home_slider__wrapper">
        <div class="home_slider__items">
            <div class="content">
                <div class="home_slider__items_item primary_slider">
                    <div class="owl-carousel owl-home home-slider-1">
                        @foreach($banners->where('block', 'block_1') as $banner)
                        <div class="item" style="background-image: url({{ '/images/medium/' . $banner->image }})">
                            <h3 class="title_slider">{{ $banner->name }}</h3>
                            <p class="descript">{{ $banner->descript }}</p>
                            <a href="{{ $banner->link }}" class="link" target="_blank">Подробнее</a>
                        </div>
                        @endforeach
                    </div>
                    <div id="counter" class="counter_slider"></div>
                </div>
                <div class="home_slider__items_item secondary_slider">
                    <div class="owl-carousel owl-home home-slider-2">
                        @foreach($banners->where('block', 'block_2') as $banner)
                        <div class="item" style="background-image: url({{ '/images/medium/' . $banner->image }})">
                            <h3 class="title_slider">{{ $banner->name }}</h3>
                            <p class="descript">{{ $banner->descript }}</p>
                            <a href="{{ $banner->link }}" class="link" target="_blank"><i class="icon-right-small"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="services">
    <div class="services__wrapper">
        <div class="services__items">
            <div class="services__items_item title">
                <h2>Услуги компании</h2>
            </div>
        </div>
        <div class="services__items">
            <div class="services__items_item serv">
                <span class="number">01.</span>
                <span class="text">Подбор оптимального объема для покупки</span>
            </div>
            <div class="services__items_item serv">
                <span class="number">02.</span>
                <span class="text">Экспертиза по всем предложениям на рынке</span>
            </div>
            <div class="services__items_item serv">
                <span class="number">03.</span>
                <span class="text">Сравнительный анализ объектов</span>
            </div>
            <div class="services__items_item serv">
                <span class="number">04.</span>
                <span class="text">Разработка стратегии управления активами в сфере недвижимости</span>
            </div>
            <div class="services__items_item serv">
                <span class="number">05.</span>
                <span class="text">Управление строительными проектами</span>
            </div>
            <div class="services__items_item serv">
                <span class="number">06.</span>
                <span class="text">Привлечение финансирования</span>
            </div>
        </div>
    </div>
</section>

<section class="new">
    <div class="new__wrapper">
        <div class="new__items">
            <div class="new__items_item title">
                <h2>Новые объявления</h2>
                <a href="{{ route('frontend.offers.index') }}">Не пропустите<i class="icon-right-small"></i></a>
            </div>
        </div>
        <div class="new__items">
            <div class="new__items_item">
                <div class="owl-carousel owl-new">
                    @foreach($offers->take(12) as $offer)
                    <a href="{{ route('frontend.offers.show', $offer->slug) }}" class="item" target="_blank">
                        <div class="top">
                            <h3 class="title">{{ $offer->name }}</h3>
                            <span class="address">{{ $offer->address }}</span>
                        </div>
                        <div class="center">
                            <div class="wrap">
                                <div class="img" style="background-image: url(
                                @foreach($offer->images as $image) 
                                    @if($image->tag == 'general')
                                        {{ 'images/small/' . $image->url }}
                                    @endif
                                @endforeach
                                )"></div>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="skills">
                                <span><img src="{{ asset('assets/images/svg/area.svg') }}" alt="area">{{ $offer->area }} м²</span>
                                <span>
                                <img src="{{ asset('assets/images/svg/planrooms.svg') }}" alt="planrooms">
                                {{ $offer->rooms }} 
                                @if ($offer->rooms == 1 )
                                    комната
                                @elseif (($offer->rooms > 1)&&($offer->rooms < 5))
                                    комнаты
                                @else
                                    комнат
                                @endif
                                </span>
                            </div>
                        </div>
                        <span class="price">
							@if($offer->price_in_rub == 0)
								По запросу
							@else
								{{ number_format($offer->price_in_rub, 0, '', ' ') }} ₽
							@endif
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mailing">
    <div class="mailing__wrapper">
        <div class="mailing__items">
            <div class="mailing__items_item">
                <h2 class="title">Будьте в курсе</h2>
                <p class="descript">Подпишитесь на последние обновления и узнавайте о новинках и специальных предложениях первыми</p>

                {{ Form::open(array('action' => 'FormController@subscribe', 'name' => 'subscribe', 'class' => 'form')) }}
                    <div class="form-group">
                        <label class="form-label" for="mailing">Ваш E-mail</label>
                        <span class="success">Спасибо, Вы подписанны!</span>
                        <span class="valid"></span>
                        <input type="hidden" name="subject" value="Подписка на рассылку">
                        <input type="hidden" name="status" value="subscribe">
                        <input class="form-input" type="text" name="email" autocomplete="off"/>
                    </div>
                    <button type="submit" class="btn btn-send">Подписаться<i class="icon-right-small"></i></button>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</section>
@if(isset($news) && ($news->count() >= 3))
<section class="news">
    <div class="news__wrapper">
        <div class="news__items">
            <div class="news__items_item title">
                <h2>Новости</h2>
                <a href="{{route('frontend.news.index')}}">Посмотреть все<i class="icon-right-small"></i></a>
            </div>
        </div>
        
        <div class="news__items">
            <div class="news__items_item">
                <div class="owl-carousel owl-new">
                   @foreach($news as $item)
                    <a href="{{ route('frontend.news.show', $item->slug) }}" class="item" target="_blank">
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
        
        <div class="news__items">
            <div class="news__items_item">
                <p class="descript">После достаточно продолжительного застоя в российской экономике в некоторых ее секторах наметился переход к восстановлению, а бизнес естественным образом адаптировался к текущим условиям. Для рынка недвижимости это означает, что состоятельные люди перешли от выжидательной позиции к предметному рассмотрению новых приобретений и непосредственно к покупке. Доходность от недвижимости в Европе обычно ниже, чем на экзотических курортах, поэтому покупатели с целью диверсификации портфеля рассматривают приобретение объектов в развивающихся регионах, где можно получить более высокий доход от девелоперских проектов, соинвестирования и сдачи в аренду.</p>
            </div>
        </div>
    </div>
</section>
@endif

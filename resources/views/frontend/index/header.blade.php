<section class="home_header">
    <div class="home_header__wrapper">
        <div class="home_header__items">
            <div class="home_header__items_item title">
                <h1 class="title">Элитная недвижимость Москвы</h1>
                <p><a href="{{ route('frontend.offers.index') }}">{{number_format($offers->count(), 0, '', ' ')}} объектов</a> жилой недвижимости</p>
            </div>
        </div>
        {{ Form::open(array('action' => 'IndexController@filter', 'id' => 'filter')) }}
            {{ Form::hidden('ajax', route('frontend.offers.ajax')) }}
            <div class="home_header__items">
                <div class="home_header__items_item type change_name">
                    <select class="form-control count xs-no-radius-b" id="type" name="type">
                        <option value="" data-txt='Не выбрано' selected="selected">Не выбрано</option>
                        <option value="eliteflat" data-txt='Квартира'>Квартира</option>
                        <option value="apartment" data-txt='Апартаменты'>Апартаменты</option>
                        <option value="penthouse" data-txt='Пентхаус'>Пентхаус</option>
                        <option value="townhouse" data-txt='Таунхаус'>Таунхаус</option>
                    </select>
                </div>
                <div class="home_header__items_item finish change_name">
                    <select class="form-control xs-no-radius count" id="finish" name="finish">
                        <option value="" data-txt='Не выбрано' selected="selected">Не выбрано</option>
                        <option value="bez-otdelki" data-txt='Без отделки'>Без отделки</option>
                        <option value="s-otdelkoj" data-txt='С отделкой'>С отделкой</option>
                    </select>
                </div>
                <div class="home_header__items_item price">
                    <div class="price_block">
                        <div class="nice-select range form-control xs-no-radius" id="price">
                            <div class="current_range">
                                <span class="val_from">0</span> -
                                <span class="val_to">1000+</span> млн.
                            </div>
                            <input type="hidden" name="price_from" class="count" value="">
                            <input type="hidden" name="price_to" class="count" value="">
                            <div class="wrap">
                                <ul class="list_half group_from">
                                    <li data-value="0" data-cur="0" data-text="0" data-cur-text="0" data-group="from" class="option selected">0</li>
                                    <li data-value="25000000" data-cur="500000" data-text="25" data-cur-text="0.5" data-group="from" class="option">25</li>
                                    <li data-value="50000000" data-cur="750000" data-text="50" data-cur-text="0.75" data-group="from" class="option">50</li>
                                    <li data-value="100000000" data-cur="1000000" data-text="100" data-cur-text="1" data-group="from" class="option">100</li>
                                    <li data-value="200000000" data-cur="2000000" data-text="200" data-cur-text="2" data-group="from" class="option">200</li>
                                    <li data-value="500000000" data-cur="8000000" data-text="500" data-cur-text="8" data-group="from" class="option">500</li>
                                </ul>
                                <ul class="list_half group_to">
                                    <li data-value="25000000" data-cur="500000" data-text="25" data-cur-text="0.5" data-group="to" class="option">25</li>
                                    <li data-value="50000000" data-cur="750000" data-text="50" data-cur-text="0.75" data-group="to" class="option">50</li>
                                    <li data-value="100000000" data-cur="1000000" data-text="100" data-cur-text="1" data-group="to" class="option">100</li>
                                    <li data-value="200000000" data-cur="2000000" data-text="200" data-cur-text="2" data-group="to" class="option">200</li>
                                    <li data-value="500000000" data-cur="8000000" data-text="500" data-cur-text="8" data-group="to" class="option">500</li>
                                    <li data-value="10000000000" data-cur="150000000" data-text="1000+" data-cur-text="15+" data-group="to" class="option selected">1000+</li>
                                </ul>
                            </div>
                        </div>
                        <select class="count currency form-control xs-no-radius" id="currency" name="currency">
                            <option value="RUB" data-txt='₽' selected="selected">₽</option>
                            <option value="USD" data-txt='$'>$</option>
                            <option value="EUR" data-txt='€'>€</option>
                        </select>
                    </div>
                </div>

                <div class="home_header__items_item area">
                    <div class="nice-select range range-click form-control xs-no-radius" id="area">
                        <div class="current_range">
                            <span class="val_from">0</span> -
                            <span class="val_to">200+</span> м²
                        </div>
                        <input type="hidden" name="area_from" class="count" value="">
                        <input type="hidden" name="area_to" class="count" value="">
                        <div class="wrap">
                            <ul class="list_half group_from">
                                <li data-value="0" data-group="from" class="option selected">0</li>
                                <li data-value="50" data-group="from" class="option">50</li>
                                <li data-value="75" data-group="from" class="option">75</li>
                                <li data-value="100" data-group="from" class="option">100</li>
                                <li data-value="125" data-group="from" class="option">125</li>
                                <li data-value="150" data-group="from" class="option">150</li>
                            </ul>
                            <ul class="list_half group_to">
                                <li data-value="50" data-group="to" class="option">50</li>
                                <li data-value="75" data-group="to" class="option">75</li>
                                <li data-value="100" data-group="to" class="option">100</li>
                                <li data-value="125" data-group="to" class="option">125</li>
                                <li data-value="150" data-group="to" class="option">150</li>
                                <li data-value="20000" data-group="to" class="option selected">200+</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="home_header__items_item district">
                    <span class="form-control xs-no-radius-t" id="btn_distr" data-fancybox data-src="#district-list">Район и метро</span>
                </div>
            </div>

            <div class="home_header__items control_group">
                <div class="home_header__items_item">
                    <a href="{{ Request::url() }}" rel="nofollow" class="reset_home"><span class="closet"></span>Сбросить</a>
                </div>
                <div class="home_header__items_item">
                    <div class="btn_group">
                        <a href="{{route('frontend.map.index')}}" class="link_map"><img src="{{ asset('assets/images/svg/map.svg') }}" alt="view map">Смотреть на карте</a>
                        <button type="submit" class="btn">Показать <span>{{$offers->count()}}</span></button>
                    </div>
                </div>
            </div>
            
         @include('frontend.district')
         
        {{ Form::close() }}
    </div>
</section>
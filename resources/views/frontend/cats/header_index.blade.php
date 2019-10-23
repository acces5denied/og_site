<section class="filter">
	<div class="filter__wrapper">
		<div class="filter__items">
			<div class="filter__items_item">
				{{ Breadcrumbs::render('cats') }}
				<h1 class="title">Элитные жилищные комплексы в Москве</h1>
			</div>
		</div>

		{{ Form::open(array('action' => 'CatsController@filter', 'id' => 'filter')) }}
			{{ Form::hidden('ajax', route('frontend.cats.filter')) }}
			<div class="filter__items">
				<div class="filter__items_item type change_name">
					<select class="form-control count xs-no-radius-b" id="type" name="type">
                        <option value="" data-txt='Не выбрано'>Не выбрано</option>
                        <option value="eliteflat" data-txt='Квартира' {{$type_data == 'eliteflat' ? 'selected' : '' }}>Квартира</option>
                        <option value="apartment" data-txt='Апартаменты' {{$type_data == 'apartment' ? 'selected' : '' }}>Апартаменты</option>
                        <option value="penthouse" data-txt='Пентхаус' {{$type_data == 'penthouse' ? 'selected' : '' }}>Пентхаус</option>
                        <option value="townhouse" data-txt='Таунхаус' {{$type_data == 'townhouse' ? 'selected' : '' }}>Таунхаус</option>у
                    </select>
				</div>
				
				
				<div class="filter__items_item finish change_name">
					<select class="form-control xs-no-radius count" id="finish" name="finish">
                            <option value="" data-txt='Не выбрано'>Не выбрано</option>
                            <option value="bez-otdelki" data-txt='Без отделки' {{$finish_data == 'bez-otdelki' ? 'selected' : '' }}>Без отделки</option>
                            <option value="s-otdelkoj" data-txt='С отделкой' {{$finish_data == 's-otdelkoj' ? 'selected' : '' }}>С отделкой</option>
                        </select>
				</div>
				<div class="filter__items_item price">
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
                                    <li data-value="0" data-cur="0" data-text="0" data-cur-text="0" data-group="from" class="option {{$price_from_data == 0 ? 'selected' : ''}}">0</li>
                                    <li data-value="25000000" data-cur="500000" data-text="25" data-cur-text="0.5" data-group="from" class="option {{$price_from_data == 25000000 ? 'selected' : $price_from_data == 500000 ? 'selected' : ''}}">25</li>
                                    <li data-value="50000000" data-cur="750000" data-text="50" data-cur-text="0.75" data-group="from" class="option {{$price_from_data == 50000000 ? 'selected' : $price_from_data == 750000 ? 'selected' : ''}}">50</li>
                                    <li data-value="100000000" data-cur="1000000" data-text="100" data-cur-text="1" data-group="from" class="option {{$price_from_data == 100000000 ? 'selected' : $price_from_data == 1000000 ? 'selected' : ''}}">100</li>
                                    <li data-value="200000000" data-cur="2000000" data-text="200" data-cur-text="2" data-group="from" class="option {{$price_from_data == 200000000 ? 'selected' : $price_from_data == 2000000 ? 'selected' : ''}}">200</li>
                                    <li data-value="500000000" data-cur="8000000" data-text="500" data-cur-text="8" data-group="from" class="option {{$price_from_data == 500000000 ? 'selected' : $price_from_data == 8000000 ? 'selected' : ''}}">500</li>
                                </ul>
                                <ul class="list_half group_to">
                                    <li data-value="25000000" data-cur="500000" data-text="25" data-cur-text="0.5" data-group="to" class="option {{$price_to_data == 25000000 ? 'selected' : $price_to_data == 500000 ? 'selected' : ''}}">25</li>
                                    <li data-value="50000000" data-cur="750000" data-text="50" data-cur-text="0.75" data-group="to" class="option {{$price_to_data == 50000000 ? 'selected' : $price_to_data == 750000 ? 'selected' : ''}}">50</li>
                                    <li data-value="100000000" data-cur="1000000" data-text="100" data-cur-text="1" data-group="to" class="option {{$price_to_data == 100000000 ? 'selected' : $price_to_data == 1000000 ? 'selected' : ''}}">100</li>
                                    <li data-value="200000000" data-cur="2000000" data-text="200" data-cur-text="2" data-group="to" class="option {{$price_to_data == 200000000 ? 'selected' : $price_to_data == 2000000 ? 'selected' : ''}}">200</li>
                                    <li data-value="500000000" data-cur="8000000" data-text="500" data-cur-text="8" data-group="to" class="option {{$price_to_data == 500000000 ? 'selected' : $price_to_data == 8000000 ? 'selected' : ''}}">500</li>
                                    <li data-value="10000000000" data-cur="150000000" data-text="1000+" data-cur-text="15+" data-group="to" class="option {{$price_to_data == 10000000000 ? 'selected' : $price_to_data == 150000000 ? 'selected' : is_null($price_to_data) ? 'selected' : ''}}">1000+</li>
                                </ul>
                            </div>
                        </div>
                        <select class="count currency form-control xs-no-radius" id="currency" name="currency">
                            <option value="RUB" data-txt='₽' {{$currency_data == 'RUB' ? 'selected' : '' }}>₽</option>
                            <option value="USD" data-txt='$' {{$currency_data == 'USD' ? 'selected' : '' }}>$</option>
                            <option value="EUR" data-txt='€' {{$currency_data == 'EUR' ? 'selected' : '' }}>€</option>
                        </select>
					</div>
				</div>

				<div class="filter__items_item area">
					<div class="nice-select range range-click form-control xs-no-radius" id="area">
						<div class="current_range">
							<span class="val_from">0</span> -
							<span class="val_to">200+</span> м²
						</div>
						<input type="hidden" name="area_from" class="count" value="">
                        <input type="hidden" name="area_to" class="count" value="">
						<div class="wrap">
							<ul class="list_half group_from">
								<li data-value="0" data-group="from" data-text="0" class="option {{$area_from_data == 0 ? 'selected' : ''}}">0</li>
								<li data-value="50" data-group="from" data-text="50" class="option {{$area_from_data == 50 ? 'selected' : ''}}">50</li>
								<li data-value="75" data-group="from" data-text="75" class="option {{$area_from_data == 75 ? 'selected' : ''}}">75</li>
								<li data-value="100" data-group="from" data-text="100" class="option {{$area_from_data == 100 ? 'selected' : ''}}">100</li>
								<li data-value="125" data-group="from" data-text="125" class="option {{$area_from_data == 125 ? 'selected' : ''}}">125</li>
								<li data-value="150" data-group="from" data-text="150" class="option {{$area_from_data == 150 ? 'selected' : ''}}">150</li>
							</ul>
							<ul class="list_half group_to">
								<li data-value="50" data-group="to" data-text="50" class="option {{$area_to_data == 50 ? 'selected' : ''}}">50</li>
								<li data-value="75" data-group="to" data-text="75" class="option {{$area_to_data == 75 ? 'selected' : ''}}">75</li>
								<li data-value="100" data-group="to" data-text="100" class="option {{$area_to_data == 100 ? 'selected' : ''}}">100</li>
								<li data-value="125" data-group="to" data-text="125" class="option {{$area_to_data == 125 ? 'selected' : ''}}">125</li>
								<li data-value="150" data-group="to" data-text="150" class="option {{$area_to_data == 150 ? 'selected' : ''}}">150</li>
								<li data-value="20000" data-group="to" data-text="200+" class="option {{$area_to_data == 20000 ? 'selected' : is_null($area_to_data) ? 'selected' : ''}}">200+</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="filter__items_item district">
					<span class="form-control xs-no-radius-t" id="btn_distr" data-fancybox data-src="#district-list">Район и метро</span>
				</div>
			</div>

			<div class="filter__items control_group">
				<div class="filter__items_item">
					<a href="{{ Request::url() }}" class="reset"><span class="closet"></span>Сбросить</a>
				</div>
				<div class="filter__items_item">
					<button type="submit" class="btn">Показать <span>{{$cats->total()}}</span></button>
				</div>
			</div>
			<div class="filter__items">
                <div class="filter__items_item"></div>
            </div>
			
			@include('frontend.district')

		{{ Form::close() }}
	</div>
</section>
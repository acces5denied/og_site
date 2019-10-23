{{ Form::open(array('action' => 'FormController@callme', 'id' => 'callme', 'name' => 'callme', 'class' => 'popup')) }}
	<div class="popup__items">
		<div class="popup__items_item">
			<p class="title">Позвоните мне</p>
		</div>
		<input type="hidden" name="subject" value="Заказ звонка">
		<input type="hidden" name="status" value="callme">
		<div class="popup__items_item input">
			<span class="valid"></span>
			<input type="text" name="name" placeholder="Имя*" autocomplete="off">
		</div>
		<div class="popup__items_item input">
			<span class="valid"></span>
			<input type="text" name="phone" placeholder="Телефон*" autocomplete="off">
		</div>
		<div class="popup__items_item person_data">
			<span>Нажимая на кнопку «Отправить», Вы даете согласие на обработку персональных данных в соответствии с</span>
			<a href="">Положением об обработке персональных данных</a>
		</div>
		<div class="popup__items_item btn_group">
			<button type="submit" class="btn btn-send">Отправить</button>
		</div>
	</div>
{{ Form::close() }}
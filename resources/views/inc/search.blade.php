<div class="search">
					
	<h3>Заказ запчастей</h3>

	<p>Заполните форму и получите 
		персональные предложения от актуальных компаний</p>

	<div id="search" href="#search-popup" class="search_button">Отправить запрос</div>

</div>

<div id="search-popup" class="mfp-hide popup">

	<div class="popup_content">

		<h3 class="popup_header">Найти запчасть</h3>
		
		<div class="popup_checks">

			<input type="checkbox" class="popup_check">
			<label class="popup_label">Новая</label>

			<input type="checkbox" class="popup_check">
			<label class="popup_label">б/у</label>

		</div>

		<div class="popup_field">
			<label class="popup_label">Тип авто</label>
			<select name="" id="select-type" class="popup_select">
			
				@foreach($types as $type)
			
					<option value="{{ $type->id }}" class="popup_option">
						{{ $type->title }}
					</option>
			
				@endforeach
			
			</select>
		</div>

		<div class="popup_field">
			<label class="popup_label">Производитель</label>
			<select name="" id="select-make" class="popup_select">
			
				@foreach($makes as $make)
			
					
			
				@endforeach
			
			</select>
		</div>

		<div class="popup_field">
			<label class="popup_label">Уточните модель</label>
			<select name="" id="select-model">
			
				@foreach($models as $model)
			
					<option value="{{ $model->id }}">{{ $model->title }}</option>
			
				@endforeach
			
			</select>
		</div>

		<div class="popup_field">
			<label class="popup_label">Год выпуска</label>
			<input type="text">
		</div>

		<div class="popup_field">
			<label class="popup_label">Дополнительная информация</label>
			<textarea name="" id="" cols="30" rows="10"></textarea>
		</div>

	</div>
	
</div>
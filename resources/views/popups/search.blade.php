<div id="search-popup" class="mfp-hide popup popup--search">

	<div class="popup_content">

		<h3 class="popup_header">Найти запчасть</h3>
		
		<div class="popup_checks">

			<input type="checkbox" class="popup_check">
			<label class="popup_label">Новая</label>

			<input type="checkbox" class="popup_check">
			<label class="popup_label">б/у</label>

		</div>

		<div class="popup_field">
			<select id="search-type" class="popup_select">

				<option class="popup_option" selected disabled>Тип авто</option>
			
				@foreach($types as $type)
			
					<option value="{{ $type->id }}" class="popup_option">
						{{ $type->title }}
					</option>
			
				@endforeach
			
			</select>
		</div>

		<div class="popup_field">
			<select id="search-make" class="popup_select">

				<option class="popup_option" selected disabled>Производитель</option>
			
			</select>
		</div>

		<div class="popup_field">
			<select id="search-model" class="popup_select">

				<option class="popup_option" selected disabled>Уточните модель</option>
			
			</select>
		</div>

		<div class="popup_field">
			<label class="popup_label">Год выпуска</label>
			<input type="text" id="search-year" class="popup_input">
		</div>

		<div class="popup_field">
			<label class="popup_label">Дополнительная информация</label>
			<textarea 
			id="search-more" cols="30" rows="7" placeholder="VIN, кузов, пожелания" 
			class="popup_textarea"></textarea>
		</div>

		<div class="popup_button">
			Запросить
		</div>

	</div>

	@include('templates.options-template')
	
</div>
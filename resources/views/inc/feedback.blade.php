<div class="feedback">

	<h3 class="feedback_h3">Нам важно мнение</h3>
	<p class="feedback_p">
		Вы можете поделиться своим мнением с другими участниками клуба
	</p>

	<div id="feedback" href="#feedback-popup" class="feedback_button">
		Написать отзыв
	</div>

</div>

<div id="feedback-popup" class="mfp-hide popup popup--feedback">

	<div class="popup_content">

		<h3 class="popup_header">Добавление отзыва об авто</h3>

		<div class="popup_field popup_field--feedback">
			<select id="feedback-type" class="popup_select">

				<option class="popup_option" selected disabled>
					Тип авто
				</option>
			
				@foreach($types as $type)
			
					<option value="{{ $type->id }}" class="popup_option">
						{{ $type->title }}
					</option>
			
				@endforeach
			
			</select>

			<select id="feedback-make" class="popup_select">

				<option class="popup_option" selected disabled>
					Производитель
				</option>
			
			</select>

			<select id="feedback-model" class="popup_select">

				<option class="popup_option" selected disabled>
					Модель
				</option>
			
			</select>

		</div>

		<div class="feedback_add-photos">

			<input id="feedback-input" 
			type="file" multiple class="feedback_input-file">
			
			<div class="popup_label">Фотографии</div>

			<div id="feedback-photos" class="feedback_photos">
				
				<div id="feedback-plus" class="feedback_add-photo"></div>

			</div>

		</div>

		<div class="popup_field">
			<label class="popup_label">Заголовок</label>
			<input type="text" class="popup_input popup_input--header">
		</div>

		<div class="popup_field">
			<label class="popup_label">Отзыв</label>
			<textarea 
			name="" id="feedback-textarea" cols="30" rows="10" 
			class="popup_textarea popup_textarea--feedback"></textarea>
		</div>

		<h4 class="popup_header--small">Выводы</h4>

		<div class="feedback_conclusions">

			<div id="feedback-pluses" class="feedback_pluses">
				
				<div>
					
					<span class="popup_label">Плюсы</span>

					<span id="feedback-add-plus" class="feedback_plus-sign">
						+
					</span>

				</div>
			
			</div>

			<div id="feedback-minuses" class="feedback_minuses">
				
				<div>
					
					<span class="popup_label">Минусы</span>

					<span id="feedback-add-minus" class="feedback_plus-sign">
						+
					</span>

				</div>

			</div>

		</div>

		<div class="popup_button">
			Добавить отзыв
		</div>

	</div>

	@include('parts.photos-template')

	@include('parts.plus-minus-template')

</div>
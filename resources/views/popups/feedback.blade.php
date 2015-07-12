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
			
			<div class="popup_label">Фотографии (10 макс)</div>

			<div id="feedback-photos" class="feedback_photos">
				
				<div id="feedback-plus" class="feedback_add-photo"></div>

			</div>

		</div>

		<div class="popup_field">
			<label class="popup_label">Заголовок</label>
			<input id="feedback-header" type="text" class="popup_input popup_input--header">
		</div>

		<div class="popup_field">
			<label class="popup_label">Отзыв</label>

			<div class="feedback_editor-wrapper">
				<div id="feedback-editor-toolbar" class="feedback_toolbar">

					<div class="ql-format-group">

						{{-- <select title="Шрифт" class="ql-font">
							<option value="Roboto">Roboto</option>
						</select> --}}
						
						<select title="Размер" class="ql-size feedback_size">
							<option value="10px">10px</option>
							<option value="14px" selected>14px</option>
							<option value="18px">18px</option>
							<option value="32px">32px</option>
						</select>

					</div>

					<div class="ql-format-group">

						<span title="Жирность" class="ql-bold ql-format-button"></span>
						
						<span class="ql-format-separator"></span>
						
						<span title="Наклон" class="ql-italic ql-format-button"></span>
						
						<span class="ql-format-separator"></span>
						
						<span title="Подчеркивание" class="ql-underline ql-format-button"></span>
						
						<span class="ql-format-separator"></span>
						
						<span title="Перечеркнутый" class="ql-strike ql-format-button"></span>

					</div>

					<div class="ql-format-group">
						
						<select title="Цвет текста" class="ql-color">
							<option value="rgb(0, 0, 0)" selected></option>
							<option value="rgb(230, 0, 0)"></option>
							<option value="rgb(255, 153, 0)"></option>
							<option value="rgb(255, 255, 0)"></option>
							<option value="rgb(0, 138, 0)"></option>
							<option value="rgb(0, 102, 204)"></option>
							<option value="rgb(153, 51, 255)"></option>
							<option value="rgb(255, 255, 255)"></option>
							<option value="rgb(250, 204, 204)"></option>
							<option value="rgb(255, 235, 204)"></option>
							<option value="rgb(255, 255, 204)"></option>
							<option value="rgb(204, 232, 204)"></option>
							<option value="rgb(204, 224, 245)"></option>
							<option value="rgb(235, 214, 255)"></option>
							<option value="rgb(187, 187, 187)"></option>
							<option value="rgb(240, 102, 102)"></option>
							<option value="rgb(255, 194, 102)"></option>
							<option value="rgb(255, 255, 102)"></option>
							<option value="rgb(102, 185, 102)"></option>
							<option value="rgb(102, 163, 224)"></option>
							<option value="rgb(194, 133, 255)"></option>
							<option value="rgb(136, 136, 136)"></option>
							<option value="rgb(161, 0, 0)"></option>
							<option value="rgb(178, 107, 0)"></option>
							<option value="rgb(178, 178, 0)"></option>
							<option value="rgb(0, 97, 0)"></option>
							<option value="rgb(0, 71, 178)"></option>
							<option value="rgb(107, 36, 178)"></option>
							<option value="rgb(68, 68, 68)"></option>
							<option value="rgb(92, 0, 0)"></option>
							<option value="rgb(102, 61, 0)"></option>
							<option value="rgb(102, 102, 0)"></option>
							<option value="rgb(0, 55, 0)"></option>
							<option value="rgb(0, 41, 102)"></option>
							<option value="rgb(61, 20, 102)"></option>
						</select>

						<span class="ql-format-separator"></span>

						<select title="Фон текста" class="ql-background">
							<option value="rgb(0, 0, 0)" selected></option>
							<option value="rgb(230, 0, 0)"></option>
							<option value="rgb(255, 153, 0)"></option>
							<option value="rgb(255, 255, 0)"></option>
							<option value="rgb(0, 138, 0)"></option>
							<option value="rgb(0, 102, 204)"></option>
							<option value="rgb(153, 51, 255)"></option>
							<option value="rgb(255, 255, 255)"></option>
							<option value="rgb(250, 204, 204)"></option>
							<option value="rgb(255, 235, 204)"></option>
							<option value="rgb(255, 255, 204)"></option>
							<option value="rgb(204, 232, 204)"></option>
							<option value="rgb(204, 224, 245)"></option>
							<option value="rgb(235, 214, 255)"></option>
							<option value="rgb(187, 187, 187)"></option>
							<option value="rgb(240, 102, 102)"></option>
							<option value="rgb(255, 194, 102)"></option>
							<option value="rgb(255, 255, 102)"></option>
							<option value="rgb(102, 185, 102)"></option>
							<option value="rgb(102, 163, 224)"></option>
							<option value="rgb(194, 133, 255)"></option>
							<option value="rgb(136, 136, 136)"></option>
							<option value="rgb(161, 0, 0)"></option>
							<option value="rgb(178, 107, 0)"></option>
							<option value="rgb(178, 178, 0)"></option>
							<option value="rgb(0, 97, 0)"></option>
							<option value="rgb(0, 71, 178)"></option>
							<option value="rgb(107, 36, 178)"></option>
							<option value="rgb(68, 68, 68)"></option>
							<option value="rgb(92, 0, 0)"></option>
							<option value="rgb(102, 61, 0)"></option>
							<option value="rgb(102, 102, 0)"></option>
							<option value="rgb(0, 55, 0)"></option>
							<option value="rgb(0, 41, 102)"></option>
							<option value="rgb(61, 20, 102)"></option>
						</select>

					</div>

					<div class="ql-format-group">
						
						<select title="Выравнивание текста" class="ql-align">
							<option value="left" selected></option>
							<option value="center"></option>
							<option value="right"></option>
							<option value="justify"></option>
						</select>

						<span class="ql-format-separator"></span>

						<span title="Список" class="ql-format-button ql-list"></span>

						<span class="ql-format-separator"></span>

						<span title="Список" class="ql-format-button ql-bullet"></span>

					</div>

				</div>
				
				<div id="feedback-editor" class="feedback_editor"></div>
			</div>

		</div>

		<h4 class="popup_header--small">Выводы</h4>

		<div class="feedback_conclusions">

			<div id="feedback-pluses" class="feedback_pluses">
				
				<div>
					
					<span class="popup_label">Плюсы</span>

					<span id="feedback-add-plus" class="popup_plus-sign">
						+
					</span>

				</div>
			
			</div>

			<div id="feedback-minuses" class="feedback_minuses">
				
				<div>
					
					<span class="popup_label">Минусы</span>

					<span id="feedback-add-minus" class="popup_plus-sign">
						+
					</span>

				</div>

			</div>

		</div>

		<div id="add-feedback" class="popup_button">
			Добавить отзыв
		</div>

	</div>

	@include('templates.photos-template')

	@include('templates.plus-minus-template')

</div>
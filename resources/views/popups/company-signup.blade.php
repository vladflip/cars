<div id="company-signup-popup" class="popup mfp-hide popup--create-company">
	
	<div class="popup_content">

		<h3 class="popup_header popup_header--left">Добавление компании</h3>
		
		<div class="popup_content--create-company">

			<div class="create-company_higher">

				<div>
					<div class="popup_field popup_field--types">
					
						<div class="popup_label">Ориентация</div>
						
						<select name="" id="create-company-type" 
						class="popup_select create-company">
					
							<option value="" disabled selected></option>
							
							@foreach($types as $type)
								
								<option value="{{ $type->id }}" class="popup_option">
									{{ $type->title }}
								</option>
					
							@endforeach
					
						</select>
					
					</div>
				</div>
				<div>
					<div class="popup_field">
					
						<div class="popup_label">Специализация</div>
						
						<select name="" id="create-company-spec" class="popup_select create-company-spec create-company">

							<option value="" disabled selected></option>
							
							@foreach($specs as $spec)
								
								<option value="{{ $spec->id }}" class="popup_option">
									{{ $spec->title }}
								</option>
					
							@endforeach
					
						</select>
					
					</div>
				</div>

			</div>

			<div id="create-company_makes-models" class="create-company_makes-models">

				<div class="popup_header-field">
					<div class="popup_label">Производители</div>
					
					<div class="popup_plus-sign">
						+
					</div>
				</div>

			</div>

			<div class="create-company_lower">

				<div>
					<div class="popup_field">
							
						<div class="popup_label">Название</div>
					
						<input id="create-company-name" type="text" class="popup_input" 
						placeholder="ООО 'Комтранс'">
					
					</div>
					
					<div class="popup_field">
							
						<div class="popup_label">Адрес</div>
					
						<input id="create-company-address" type="text" class="popup_input" 
						placeholder="город, улица, дом...">
					
					</div>
					
					<div class="popup_field">
							
						<div class="popup_label">Телефоны</div>
					
						<input id="create-company-phone" type="text" class="popup_input" 
						placeholder="8 (495) 123-45-67">
					
					</div>
				</div>

				<div>
					<div class="popup_field">
					
						<div class="popup_label">Кратко о компании</div>
					
						<textarea name="" id="create-company-about" cols="30" rows="7" class="popup_textarea"></textarea>
					
					</div>
					
					<div class="popup_field">
					
						<div class="popup_header-field">
					
							<div id="create-company-logo-label" class="popup_label">Логотип <i>(если есть)</i></div>
							
							<div id="create-company-logo-btn" class="popup_pick-file">
								Выбрать файл
							</div>
					
							<input type="file" id="create-company-logo">
					
						</div>
					
						<div id="create-company-logo-html" class="popup_comp-logo"></div>
					
					</div>
				</div>

			</div>

		</div>

		<div id="company-signup-auth">

			<h3 class="popup_header popup_header--left">Доступ к сайту</h3>
			
			<div class="popup_field">
					
				<label class="popup_label">Введите e-mail</label>
			
				<input name="email" type="email" class="popup_input company-signup-email">
			
			</div>
			
			<div class="popup_field">
				
				<label class="popup_label">Придумайте пароль</label>
			
				<input name="password" type="text" class="popup_input company-signup-pass">
			
			</div>

		</div>

		<div id="create-company-submit" class="popup_button">Добавить</div>

	</div>

</div>

@include('templates.create-company-make')

@include('templates.create-company-model')

@include('templates.create-company-models-list')
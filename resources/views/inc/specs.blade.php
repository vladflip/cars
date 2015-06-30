<div class="specs sticky">
					
	<h3 class="specs_header">Каталог Организаций</h3>

	<ul class="specs_menu">
		
		@foreach($specs as $spec)
			
			@if($current)

				<li class="{{ $current == $spec->name ? 'specs_active' : '' }}">

			@else

				<li>

			@endif

					<a href="{{ route('specs', $spec->name) }}">
						{{ $spec->title }}
					</a>
				</li>

		@endforeach

	</ul>

	<div id="create-company-button" class="specs_add" href="#create-company">
		Добавить организацию
	</div>

</div>

<div id="create-company" class="popup mfp-hide popup--create-company">
	
	<div class="popup_content">

		<h3 class="popup_header popup_header--left">Ваша компания</h3>
		
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
						
						<select name="" id="create-company-spec" class="popup_select">
							
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

				{{-- <div class="create-company_makes-models_item">

					<div class="create-company_make popup_field">
								
						<select name="" class="create-company_select popup_select"></select>
					
					</div>
					
					
					<div class="create-company_models">
							
						<div class="popup_header-field">
							<div class="popup_label">Уточнить модель</div>
							
							<div class="popup_plus-sign">
								+
							</div>
						</div>
					
						<div class="create-company_model popup_field">
							
							<select name="" class="create-company_select popup_select"></select>
											
						</div>
					
					</div>

				</div> --}}

			</div>

			<div class="create-company_lower">

				<div>
					<div class="popup_field">
							
						<div class="popup_label">Название</div>
					
						<input type="text" class="popup_input" 
						placeholder="ООО 'Комтранс'">
					
					</div>
					
					<div class="popup_field">
							
						<div class="popup_label">Адрес</div>
					
						<input type="text" class="popup_input" 
						placeholder="г. Москва Красная пл, д1">
					
					</div>
					
					<div class="popup_field">
							
						<div class="popup_label">Телефоны</div>
					
						<input type="text" class="popup_input" 
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
					
							<div class="popup_label">Логотип</div>
							
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

		<div class="popup_button">Зарегистрировать</div>

	</div>

</div>

@include('parts.create-company-make')

@include('parts.create-company-model')

@include('parts.create-company-models-list')
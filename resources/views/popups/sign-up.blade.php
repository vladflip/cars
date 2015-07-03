<div id="sign-up-popup" class="mfp-hide popup popup--sign-up">
	
	<div class="popup_content">
		
		<h3 class="popup_header">Регистрация</h3>

		{!! Form::open(['method' => 'post', 'route' => 'user-create', 'id' => 'sign-up-form']) !!}

			<div class="popup_field">
				
				<label class="popup_label">Введите e-mail</label>
			
				<input name="email" type="email" class="popup_input">
			
			</div>
			
			<div class="popup_field">
				
				<label class="popup_label">Придумайте пароль</label>
			
				<input name="password" type="text" class="popup_input">
			
			</div>

			{!! Form::token() !!}
			
			<div id="sign-up-button" class="popup_button">
				Зарегистрировать
			</div>

		{!! Form::close() !!}

	</div>

</div>
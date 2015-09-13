<div id="sign-up-popup" class="mfp-hide popup popup--sign-up">
	
	<div class="popup_content">
		
		<h3 class="popup_header">Регистрация<br>в клубе "Комтранс"</h3>
		<div class="popup_info">*Вам станет доступен специализированный поиск товаров и услуг для грузовых авто.</div>

		{!! Form::open(['method' => 'post', 'route' => 'user-create', 'id' => 'sign-up-form']) !!}

			<div class="popup_field">
				
				<label class="popup_label">Введите e-mail</label>
			
				<input name="email" type="email" class="popup_input">
			
			</div>
			
			<div class="popup_field">
				
				<label class="popup_label">Введите пароль</label>
			
				<input name="password" type="text" class="popup_input">
			
			</div>

			<div>
			
				<input name="agree" type="checkbox" class="popup_agree">
				<div>Согласен с <a href="">правилами</a> клуба.</div>
			
			</div>
			
			<div id="sign-up-button" class="popup_button">
				Зарегистрироваться
			</div>

		{!! Form::close() !!}

	</div>

</div>
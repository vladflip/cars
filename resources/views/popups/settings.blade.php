<div id="settings-popup" class="popup mfp-hide popup--settings">

	<div class="popup_content">
	
		<div class="popup_header"><b>Настройки</b></div>

		<div class="popup_field">
			<div class="popup_label">Почта</div>
			<input id="settings-email" type="text" class="popup_input" value="{{ Auth::user()->email }}">
		</div>
		
		<div id="settings-email-button" class="popup_button" style="margin:20px auto">Изменить почту</div>

		<div class="popup_field">
			<div class="popup_label">Пароль</div>
			<input type="text" class="popup_input" placeholder="Текущий пароль">
			<input type="text" class="popup_input" placeholder="Новый пароль">
			<input type="text" class="popup_input" placeholder="Повторите новый пароль">
		</div>

		<div class="popup_button" style="margin:20px auto">Изменить пароль</div>

		<hr>

		<div class="popup_field">
			<div class="popup_button" style="margin:20px auto">Удалить аккаунт</div>
		</div>

	</div>

</div>
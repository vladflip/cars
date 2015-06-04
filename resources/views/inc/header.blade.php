<div class="header">
	
	<div class="container">
		
		<div>
			<div class="header_logo"></div>
			
			<div class="header_title">
				Справочник коммерческих организаций по обслуживанию авто и продажам запчастей.
			</div>
		</div>

		<div>

			@if(Request::is('profile'))
			
				<div class="user-info">
					
					<span>x</span>
			
					<div class="user-info_names">
						<h5>Павел Калачов</h5>
						<h5>Ренестранском</h5>
					</div>
			
					<div class="user-info_ava">
						<img src="img/ava.jpg" alt="">
					</div>
			
				</div>
			
			@else
				
				<div class="header_inputs">
			
					<input class="header_login" type="text" placeholder="Логин">
					
					<input class="header_pass" type="password" placeholder="Пароль">

					<div class="header_submit-arrow"></div>
			
				</div>

				<div class="header_register">Регистрация</div>
			
			@endif

		</div>

	</div>

</div>
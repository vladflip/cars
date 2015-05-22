<div class="header">
	
	<div class="h_c container">
		
		<div class="h_logo"></div>

		<div class="h_title">
			Справочник коммерческих организаций по обслуживанию авто и продажам запчастей.
		</div>

		@if(Request::is('profile'))

			<div class="h_profile">
				
				<span>x</span>

				<div class="h_p_names">
					<h5>Павел Калачов</h5>
					<h5>Ренестранском</h5>
				</div>

				<div class="h_p_ava">
					<img src="img/ava.jpg" alt="">
				</div>

			</div>

		@else
			
			<div class="h_buttons">

				<div class="h_b-signup">Регистрация</div>
				
				<div class="h_b-signin">Вход</div>

			</div>

		@endif

	</div>

</div>
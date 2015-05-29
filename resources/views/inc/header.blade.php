<div class="header">
	
	<div class="container">
		
		<div class="header_logo"></div>

		<div class="header_title">
			Справочник коммерческих организаций по обслуживанию авто и продажам запчастей.
		</div>

		@if(Request::is('profile'))

			<div class="profile">
				
				<span>x</span>

				<div class="profile_names">
					<h5>Павел Калачов</h5>
					<h5>Ренестранском</h5>
				</div>

				<div class="profile_ava">
					<img src="img/ava.jpg" alt="">
				</div>

			</div>

		@else
			
			<div class="header_buttons">

				<div class="header_signup">Регистрация</div>
				
				<div class="header_signin">Вход</div>

			</div>

		@endif

	</div>

</div>
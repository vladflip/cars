<div class="header">
	
	<div class="container">
		
		<div>
			<div class="header_logo"></div>
			
			<div class="header_title">
				Справочник коммерческих организаций по обслуживанию авто и продажам запчастей.
			</div>
		</div>

		<div>

			@if(Auth::check())
			
				{{-- <div class="user-info">
					
					<span>x</span>
			
					<div class="user-info_names">
						<h5>Павел Калачов</h5>
						<h5>Ренестранском</h5>
					</div>
			
					<div class="user-info_ava">
						<img src="img/ava.jpg" alt="">
					</div>
			
				</div> --}}
			
			@else

			{!! Form::open(['method' => 'POST', 'route' => 'user-auth', 'id' => 'user-auth-form']) !!}
				
				<div class="header_inputs">

					<input name="email" class="header_login" type="email" placeholder="Почта">
					
					<input name="password" class="header_pass" type="password" placeholder="Пароль">

					<div id="user-auth-button" class="header_submit-arrow"></div>

				</div>

			{!! Form::close() !!}

				<div id="sign-up" href="#sign-up-popup" class="header_sign-up">
					Регистрация
				</div>

				@include('popups.sign-up')
			
			@endif

		</div>

	</div>

</div>
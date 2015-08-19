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
			
				<a class="header_user-info" href="{{ route('profile') }}">

					<div class="header_user-info_arrow"></div>
			
					<div class="header_user-info_names">

						@if(Auth::user()->name)
							
							<h5>{{ Auth::user()->name }}</h5>

						@else

							<h5>{{ Auth::user()->email }}</h5>

						@endif

						@if(Auth::user()->company)
							<h5 class="header_user-info_company-name">{{ Auth::user()->company->name }}</h5>
						@endif

					</div>

					@if(Auth::user()->company)
						<div class="header_user-info_ava" 
						style="background-image:url({{ URL::to('/') . '/' . Auth::user()->company->logo }})">
						</div>
					@elseif(Auth::user()->ava)
						<div class="header_user-info_ava" 
						style="background-image:url({{ URL::to('/') . '/' . Auth::user()->ava }})">
						</div>
					@else
						<div class="header_user-info_ava" 
						style="background-image:url({{ URL::to('/') }}/img/noavatar.png)"></div>
					@endif
					
					@if(Auth::user()->company)
						@if($requestsCount)
							<span class="header_user-info_notification">
								+{{ $requestsCount }}
							</span>
						@endif
					@elseif($responsesCount)
						<span class="header_user-info_notification">
							+{{ $responsesCount }}
						</span>
					@endif
			
				</a>
			
			@else
				
			<div id="user-auth" class="header_inputs">

				<input name="email" class="header_login" type="email" placeholder="Почта">
				
				<input name="password" class="header_pass" type="password" placeholder="Пароль">

				<div id="user-auth-button" class="header_submit-arrow"></div>

			</div>
			
			@endif

		</div>

	</div>

</div>
<div class="profile-info">

	<div class="profile-info_header">
	
		<div class="profile-info_toogler">

			<div id="profile-show-company" 
			class="profile-info_company profile-info_toogler--active">
				Моя компания
			</div>
			
			<div id="profile-show-user" class="profile-info_profile">
				Мой профиль
			</div>

		</div>

		<div id="profile-settings" class="profile_settings" href="#settings-popup">
			<span class="profile_settings-icon"></span>
			Настройки
		</div>

	</div>
	
	<div class="profile-info_body">

		<div class="profile-info_left">
			
			<div class="profile-info_logo" id="company-ava">
				<img src="{{ URL::to('/') . '/' . $user->company->logo }}" alt="">
			</div>

			<div class="profile-info_logo profile--hidden" id="user-ava">
				<img
					src="{{ $user->ava ? 
					URL::to('/') . '/' . $user->ava : 
					URL::to('/') . '/img/noavatar.png' }}" alt="">
			</div>
			
			<input type="file" style="display:none" id="user-ava-file">

			<input type="file" style="display:none" id="company-ava-file">

			<div id="avatar-popup" class="popup mfp-hide popup--avatar"></div>
		
		</div>
		
		<div class="profile-info_right">
			
			<div id="profile-company-info">

				<div class="profile_row">
					<div class="profile_label">Компания:</div>
					<h3 id="profile-company-name" class="profile-info_name">
						<span>{{ $user->company->name }}</span>
						<span id="profile-company-pen" href="#edit-company-profile-popup" class="profile-info_pen"></span>
					</h3>
				</div>
										
				<div class="profile_row">
					<div class="profile_label">Адрес:</div>
					<div id="profile-company-address" class="profile-info_address">
						{{ $user->company->address }}
					</div>
				</div>
										
				<div class="profile_row">
					<div class="profile_label">Телефон:</div>
					<div id="profile-company-phone" class="profile-info_phone">
						{{ $user->company->phone }}
					</div>
				</div>
				
				<div class="profile_row">
					<div class="profile_label">Описание:</div>
					<div id="profile-company-about" class="profile-info_about">
						{{ $user->company->about }}
					</div>
				</div>

			</div>

			<div id="profile-user-info" class="profile_row profile--hidden">
				<div class="profile_label">Имя:</div>
				<h3 id="profile-user-name" class="profile-info_name">
					<span>{{ $user->name ? $user->name : $user->email }}</span>
					<span id="profile-user-pen" href="#edit-user-profile-popup" class="profile-info_pen">
					</span>
				</h3>
			</div>						
		
			<div id="profile-company-tags" class="profile_row">
				<div class="profile_label">Специализация:</div>
				<ul class="profile-info_tags">
					
					<li>{{ $user->company->spec->title }}</li>
					<li>{{ $user->company->type->title }}</li>
				
					@foreach($user->company->makes as $make)
						<li>{{ $make->title }}</li>
					@endforeach
										
				</ul>
			</div>
		
		</div>

	</div>

</div>
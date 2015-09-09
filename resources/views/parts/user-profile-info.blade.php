<div class="profile-info">

	<div class="profile-info_header">
	
		<div class="profile-info_toogler">

			<div class="profile-info_profile profile-info_toogler--active">
				Мой профиль
			</div>
			
			@if( ! $user->company)
				<div id="create-company-button" class="profile-info_company" 
				href="{{ $user->is_ready() ? '#create-company' : '#fill-up-profile-popup' }}">
					Создать компанию
				</div>
			@else
				<span style="font-size:14px; color:#777">Ваша компания ожидает модерацию</span>
			@endif

		</div>

		<div id="profile-settings" class="profile_settings" href="#settings-popup">
			<span class="profile_settings-icon"></span>
			Настройки
		</div>

	</div>
	
	<div class="profile-info_body">

		<div class="profile-info_left">
			
			<div class="profile-info_logo" id="user-ava">
				<img
				src="{{ $user->ava ? 
				URL::to('/') . '/' . $user->ava : 
				URL::to('/') . '/img/noavatar.png' }}" alt="">
			</div>
			
			<input type="file" style="display:none" id="user-ava-file">

			<div id="avatar-popup" class="popup mfp-hide popup--avatar"></div>
		
		</div>
		
		<div class="profile-info_right">
			
			<div class="profile_row">
				<div class="profile_label">Имя:</div>
				<h3 id="profile-user-name" class="profile-info_name">
					<span>{{ $user->name ? $user->name : 'Аноним.' }}</span>
					<span id="profile-user-pen" href="#edit-user-profile-popup" class="profile-info_pen">
					</span>
				</h3>
			</div>
		
		</div>

	</div>

</div>
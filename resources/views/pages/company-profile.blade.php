@extends('layouts.main')

@section('body')

	<div class="profile">
		
		<div class="container">
			
			<div class="profile_left">

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

						<div class="profile_settings">
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
								<img src="{{ URL::to('/') . '/' . $user->ava  }}" alt="">
							</div>
							
							<input type="file" style="display:none" id="user-ava-file">

							<input type="file" style="display:none" id="company-ava-file">

							<div id="avatar-popup" class="popup mfp-hide popup--avatar"></div>
						
						</div>
						
						<div class="profile-info_right">
							
							<div id="profile-company-info">

								<h3 id="profile-company-name" class="profile-info_name">
									<span>{{ $user->company->name }}</span>
									<span id="profile-company-pen" href="#edit-company-profile-popup" class="profile-info_pen"></span>
								</h3>
														
								<div id="profile-company-address" class="profile-info_address">
									{{ $user->company->address }}
								</div>
														
								<div id="profile-company-phone" class="profile-info_phone">
									{{ $user->company->phone }}
								</div>
								
								<div id="profile-company-about" class="profile-info_about">
									{{ $user->company->about }}
								</div>

							</div>

							<div id="profile-user-info" class="profile--hidden">
								<h3 id="profile-user-name" class="profile-info_name">
									<span>{{ $user->name }}</span>
									<span id="profile-user-pen" href="#edit-user-profile-popup" class="profile-info_pen">
									</span>
								</h3>
							</div>
						
						
							<ul id="profile-company-tags" class="profile-info_tags">
								
								<li>{{ $user->company->spec->title }}</li>
								<li>{{ $user->company->type->title }}</li>

								@foreach($user->company->makes as $make)
									<li>{{ $make->title }}</li>
								@endforeach
						
							</ul>
						
						</div>

					</div>

				</div>
				
				@if($requests)
		
					<div class="requests">
						
						<div class="requests_header">
							
							<div class="requests_toogler">

								{{-- <div class="requests_received requests_toogler--active">Исходящие запросы</div> --}}
								
								<div class="requests_sent requests_toogler--active">
									Входящие запросы {{ '+' . $user->company->requests_count() }}
								</div>

							</div>

						</div>

						{{-- @include('parts.sent-requests') --}}

						@include('parts.received-requests')

					</div>

				@endif

			</div>

			<div class="profile_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

	@include('popups.edit-profile', [
		'id' => 'edit-company-profile-popup', 
		'button_id' => 'edit-company-profile-button'
	])

	@include('popups.edit-profile', [
		'id' => 'edit-user-profile-popup', 
		'button_id' => 'edit-user-profile-button'
	])

	@include('templates.popup-field-template')

	@include('templates.avatar-template')

@stop
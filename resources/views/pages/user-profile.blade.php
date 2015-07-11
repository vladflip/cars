@extends('layouts.main')

@section('body')

	<div class="profile">
		
		<div class="container">
			
			<div class="profile_left">

				@if($user->confirmed)

					<div class="profile-info">

						<div class="profile-info_header">
						
							<div class="profile-info_toogler">

								<div class="profile-info_profile profile-info_toogler--active">
									Мой профиль
								</div>
								
								<div id="create-company-button" href="#create-company" class="profile-info_company">
									Создать компанию
								</div>

							</div>

							<div class="profile_settings">
								<span class="profile_settings-icon"></span>
								Настройки
							</div>

						</div>
						
						<div class="profile-info_body">

							<div class="profile-info_left">
								
								<div class="profile-info_logo">
									<img 
									src="{{ $user->ava ? $user->ava : URL::to('/') . '/img/ava.jpg' }}" alt="">
								</div>
							
							</div>
							
							<div class="profile-info_right">
								
								<h3 id="edit-profile-name" class="profile-info_name">
									<span>{{ $user->name }}</span>
									<span id="profile-pen" href="#edit-profile-popup" class="profile-info_pen">
									</span>
								</h3>
							
								<div id="edit-profile-address" class="profile-info_address">
									{{ $user->address }}
								</div>
							
								<div id="edit-profile-phone" class="profile-info_phone">
									{{ $user->phone }}
								</div>

								<div id="edit-profile-about" class="profile-info_about">
									{{ $user->about }}
								</div>
							
							</div>

						</div>

					</div>

				@else

					<div class="profile_verify">
						Подтвердите свою почту. 
						На вашу почту (
							<a href="http://{{ $user->email_provider() }}">{{ $user->email_provider() }}</a>
						) было выслано письмо.
					</div>

				@endif

				@if(count($user->requests))

					<div class="requests">
						
						<div class="requests_header">
							
							<div class="requests_toogler">

								<div class="requests_received requests_toogler--active">Исходящие запросы</div>

							</div>

						</div>

						@include('parts.sent-requests', 
							['requests' => $user->requests])

					</div>

				@endif


			</div>

			<div class="profile_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

	@include('popups.create-company')

	@include('popups.edit-profile')

	@include('templates.popup-field-template')

@stop
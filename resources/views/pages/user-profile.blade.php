@extends('layouts.main')

@section('body')

	<div class="profile">
		
		<div class="container">
			
			<div class="profile_left">

				<div class="profile-info">

					<div class="profile-info_header">
					
						<div class="profile-info_toogler">

							<div class="profile-info_profile profile-info_toogler--active">
								Мой профиль
							</div>
							
							<div class="profile-info_company">
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
								<img src="{{ $user->ava or URL::to('/') . '/img/ava.jpg' }}" alt="">
							</div>
						
						</div>
						
						<div class="profile-info_right">
							
							<h3 class="profile-info_name">
								{{ $user->name or 'имя' }}
								<span class="profile-info_pen"></span>
							</h3>
						
							<div class="profile-info_address">
								{{ $user->address or 'адрес' }}
							</div>
						
							<div class="profile-info_phone">
								{{ $user->phone or 'телефон' }}
							</div>

							<div class="profile-info_about">
								{{ $user->description or 'о себе' }}
							</div>
						
						</div>

					</div>

				</div>

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

@stop
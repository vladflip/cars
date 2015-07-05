@extends('layouts.main')

@section('body')

	<div class="profile">
		
		<div class="container">
			
			<div class="profile_left">

				<div class="profile-info">

					<div class="profile-info_header">
					
						<div class="profile-info_toogler">

							<div class="profile-info_company profile-info_toogler--active">
								Моя компания
							</div>
							
							<div class="profile-info_profile">
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
							
							<div class="profile-info_logo">
								<img src="img/com_logo.jpg" alt="">
							</div>
						
						</div>
						
						<div class="profile-info_right">
							
							<h3 class="profile-info_name">
								ООО Трансавтосервис
								<span class="profile-info_pen"></span>
							</h3>
						
							<div class="profile-info_address">
								Москва, Россия
							</div>
						
							<div class="profile-info_phone">
								8 (967) 176-66-77
							</div>

							<div class="profile-info_about">
								Мы предоставляем нашим клиентам запчасти по самым низким ценам от любых производителей.
							</div>
						
						
							<ul class="profile-info_tags">
								
								<li>Автобусы</li>
								<li>Грузовики</li>
								<li>BMW</li>
								<li>Шиномонтаж</li>
						
							</ul>
						
						</div>

					</div>

				</div>

				<div class="requests">
					
					<div class="requests_header">
						
						<div class="requests_toogler">

							<div class="requests_received requests_toogler--active">Исходящие запросы</div>
							
							<div class="requests_sent">Входящие (+2)</div>

						</div>

					</div>

					@include('parts.sent-requests')

					@include('parts.received-requests')

				</div>

			</div>

			<div class="profile_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

@stop
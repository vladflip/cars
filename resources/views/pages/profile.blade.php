@extends('layouts.main')

@section('body')

	<div class="profile">
		
		<div class="container">
			
			<div class="profile_left">

				<div class="profile-info">

					<div class="profile-info_header">
					
						<div class="profile-info_toogler">

							<div class="profile-info_toogler--active">
								Моя компания
							</div>
							
							<div>
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

				<div class="p_requests">
					
					<div class="p_request-header">
						
						<h3>Входящие запросы</h3>

						<h4>Исходящие (+2)</h4>

					</div>

					<ul class="p_request-list">
						
						<li>
							<div class="left">
								<div class="left"><img src="" alt=""></div>
								<div class="right">
									<h4>BMW - A2831</h4>
									<span>12 апреля 2015</span>
								</div>
							</div>
							<div class="left">
								<div class="p_request">
									Нужно сегодня
								</div>
							</div>
							<div class="clear-fix"></div>
						</li>
						<li>
							<div class="left">
								<div class="left"><img src="" alt=""></div>
								<div class="right">
									<h4>Dodge - CR1234855</h4>
									<span></span>
								</div>
							</div>
							<div class="left">
								<div class="p_request">
									Нужно сегодня
								</div>
							</div>
						</li>

					</ul>

				</div>

			</div>

			<div class="profile_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

@stop
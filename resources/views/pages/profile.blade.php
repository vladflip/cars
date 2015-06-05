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
					
					<div class="request_header">
						
						<div class="requests_toogler">

							<div class="requests_received requests_toogler--active">Исходящие запросы</div>
							
							<div class="requests_sent">Входящие (+2)</div>

						</div>

					</div>

					<div class="sent-requests">

						<div class="sent-requests_item">
							
							<div class="sent-requests_request">
								
								<div class="sent-requests_logo-name">

									<div class="requests_logo">
										<img src="img/ava.jpg" alt="">
									</div>

									<div class="requests_name">
										Павел Калачев
									</div>

								</div>

								<div class="sent-requests_body sent-requests_body--yellow">
									Lorem ipsum dolor sit amet, consectetur adipisicing.
									Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam eum ipsum aspernatur facere aliquid eius vitae ipsam rerum porro debitis.
								</div>

								<div class="sent-requests_time">
									20 мая 2015
								</div>

							</div>

							<div class="sent-requests_answer">
								
								<div class="sent-requests_answ-time">
									20 мая
								</div>

								<div class="sent-requests_answer-info">
									
									<div class="sent-requests_logo-name">
										
										<div class="requests_logo">
											<img src="img/com_logo.jpg" alt="">
										</div>

										<div class="requests_name">
											ООО Трансавтосервис
										</div>

									</div>

									<div class="sent-requests_answer-contacts">
										г. Москва, ул. Улица д21 <br>
										843 089 98 4, 34 98432 7893
									</div>

								</div>

								<div class="sent-requests_answer-body sent-requests_body--grey">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore est esse nesciunt optio illo tempora sapiente aspernatur recusandae. Totam, iste.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore harum porro doloribus provident, deleniti ducimus minus, repellendus.
								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			<div class="profile_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

@stop
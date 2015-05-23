@extends('layouts.main')

@section('body')

	<div class="profile-content">
		
		<div class="container">
			
			<div class="p_left">
				
				<div class="p_info-header">
					
					<h3>Моя компания</h3>

					<h4>Мой профиль</h4>

					<div class="p_settings">
						Настройки
					</div>

				</div>

				<div class="p_info">
					
					<div class="left">
						
						<img src="img/com_logo.jpg" alt="">

					</div>

					<div class="right">
						
						<h3>ООО Трансавтосервис</h3>

						<div>Москва, Россия</div>

						<div>8 (967) 176-66-77</div>


						<ul class="p_tags">
							
							<li>Автобусы</li>
							<li>Грузовики</li>
							<li>BMW</li>
							<li>Шиномонтаж</li>

						</ul>

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

		</div>

	</div>

@stop
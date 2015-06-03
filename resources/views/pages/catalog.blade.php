@extends('layouts.main')

@section('body')
	
	<div class="catalog-content">
		
		<div class="wide-image"></div>

		<div class="c_c container">
			
			<div class="c_left">
				
				<div class="c_top">
					
					<h3>Каталог Организаций</h3>
					
					<div class="c_add-organization">
						Добавить организацию
					</div>
					
					@include('inc.toogler')

				</div>

				@include('inc.type')

				@include('inc.makes')

				<div class="founded-orgs">

					<hr>

					<h2>Найденные организации</h2>

					<ul>
						<li>
							<div class="f-o_logo"></div>
							<div class="org-text">
								<h3>ООО Трансавтосервис</h3>
								<h5>Москва, Россия</h5>
								<h5>Запчасти по самым низким ценам</h5>
							</div>
						</li>
						<li>
							<div class="f-o_logo"></div>
							<div class="org-text">
								<h3>Автодор Мобайл</h3>
								<h5>Воронеж, Россия</h5>
								<h5>Быстрое и дешевое решение любых проблем</h5>
							</div>
						</li>
						<li>
							<div class="f-o_logo"></div>
							<div class="org-text">
								<h3>ЧУП Вандервилль</h3>
								<h5>Саратов, Россия</h5>
								<h5>Разберем и соберем все</h5>
							</div>
						</li>
						<li>
							<div class="f-o_logo"></div>
							<div class="org-text">
								<h3>Колор энд драйв</h3>
								<h5>Москва, Россия</h5>
								<h5>Самые эффективные решения</h5>
							</div>
						</li>
						<li>
							<div class="f-o_logo"></div>
							<div class="org-text">
								<h3>ООО Трансавтосервис</h3>
								<h5>Москва, Россия</h5>
								<h5>Запчасти по самым низким ценам</h5>
							</div>
						</li>
						<li>
							<div class="f-o_logo"></div>
							<div class="org-text">
								<h3>Автодор Мобайл</h3>
								<h5>Воронеж, Россия</h5>
								<h5>Быстрое и дешевое решение любых проблем</h5>
							</div>
						</li>
						<li>
							<div class="f-o_logo"></div>
							<div class="org-text">
								<h3>ЧУП Вандервилль</h3>
								<h5>Саратов, Россия</h5>
								<h5>Разберем и соберем все</h5>
							</div>
						</li>
						<li>
							<div class="f-o_logo"></div>
							<div class="org-text">
								<h3>Колор энд драйв</h3>
								<h5>Москва, Россия</h5>
								<h5>Самые эффективные решения</h5>
							</div>
						</li>
						<div class="clear-fix"></div>
					</ul>

					<div class="c_show-more-orgs">
						Показать еще
					</div>

				</div>

			</div>

			<div class="c_right">
				
				<div class="search-side-bar">
					
					<h3>Найти</h3>

					<div class="s-s_toogler">
						<div class="s_t_parts">
							Запчасти
						</div>
						<div class="s_t_services">
							Услуги
						</div>
					</div>

					<p>
						Отправьте запрос, на который ответят специалисты
						профильных организаций
					</p>

				</div>

				@include('inc.feedback')

			</div>

		</div>

	</div>

@stop
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

				@include('inc.found')

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
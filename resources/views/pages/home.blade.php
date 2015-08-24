@extends('layouts.main')

@section('body')

	<div class="home">

		<div class="wide-image"></div>
		
		<div class="container">
			
			<div class="home_left">
				

				<div class="company-signup">
						
					<h3>Регистрация Вашей компании</h3>

					<p>Добавьте свою компанию в каталог и получайте новых клиентов</p>

					<div id="" class="company_add" href="#sign-up-popup">
						Добавить
					</div>

				</div>


				@include('inc.specs')

			</div>

			<div class="home_middle">
				
				<h3>Поиск организаций</h3>

				@include('inc.type', ['id' => 'main-type-list'])

				@include('inc.parts')

				@include('inc.main-makes')

				<div id="show-found-orgs" class="show-orgs">
					Показать
				</div>

				{{-- @include('inc.found') --}}

				<div id="found" class="found"></div>

				@include('templates.found-template')

				@include('templates.company-template')

				<div class="company-popup mfp-hide" id="company-main-popup"></div>

			</div>

			<div class="home_right">
				
				<div class="sticky">
					@include('inc.search')
					
					@include('inc.feedback')
				</div>

			</div>

			<div class="clear-fix"></div>

		</div>

	</div>

@stop
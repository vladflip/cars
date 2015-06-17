@extends('layouts.main')

@section('body')

	<div class="home">

		<div class="wide-image"></div>
		
		<div class="container">
			
			<div class="home_left">
				
				@include('inc.specs')

			</div>

			<div class="home_middle">
				
				<h3>Поиск организации</h3>

				@include('inc.type', ['id' => 'main-type-list'])

				@include('inc.parts')

				@include('inc.main-makes')

				<div id="show-orgs" class="show-orgs">
					Показать
				</div>

				@include('inc.found')

				@include('parts.found-template')

			</div>

			<div class="home_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

			<div class="clear-fix"></div>

		</div>

	</div>

@stop
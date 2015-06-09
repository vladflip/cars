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

				@include('inc.type')

				@include('inc.parts')

				@include('inc.makes', ['live' => true])

				<div class="show-orgs">
					Показать
				</div>

				@include('inc.found')

			</div>

			<div class="home_right">
				
				@include('inc.search')

			</div>

			<div class="clear-fix"></div>

		</div>

	</div>

@stop
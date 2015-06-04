@extends('layouts.main')

@section('body')

	<div class="home-content">

		<div class="wide-image"></div>
		
		<div class="container">
			
			<div class="home-content_left">
				
				@include('inc.org-catalog')

			</div>

			<div class="home-content_middle">
				
				<h3>Поиск организации</h3>

				@include('inc.type')

				@include('inc.parts')

				@include('inc.makes')

				<div class="show-orgs">
					Показать
				</div>

				@include('inc.found')

			</div>

			<div class="home-content_right">
				
				@include('inc.search')

			</div>

			<div class="clear-fix"></div>

		</div>

	</div>

@stop
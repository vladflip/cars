@extends('layouts.main')

@section('body')

	<div class="home">

		<div class="wide-image"></div>
		
		<div class="container">
			
			<div class="home_left">
				

				@include('inc.company-signup')


				@include('inc.specs')

			</div>

			<div class="home_middle">
				
				<h3>Поиск организаций</h3>

				<div id="type-makes-ids">
					@foreach($ids as $id)
						
						<div data-ids="{{ $id }}"></div>

					@endforeach
				</div>

				@include('inc.type', ['id' => 'catalog-types'])

				@include('inc.makes.makes', ['id' => 'catalog-makes'])

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
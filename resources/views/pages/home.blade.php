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
				
				<svg xmlns="http://www.w3.org/2000/svg" fill="#000000" height="24" viewBox="0 0 24 24" width="24">
					<path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/>
					<path d="M0 0h24v24H0z" fill="none"/>
				</svg>

				<div id="type-makes-ids">
					@foreach($ids as $id)
						
						<div data-ids="{{ $id }}"></div>

					@endforeach
				</div>

				@include('inc.type')

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
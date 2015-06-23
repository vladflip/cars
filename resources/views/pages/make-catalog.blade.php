@extends('layouts.main')

@section('body')
	
	<div class="catalog">
		
		<div class="wide-image"></div>

		<div class="container">

			<div class="catalog_left">
				
				@include('inc.specs')

			</div>
			
			<div class="catalog_middle">
				
				{{-- bread crumps --}}

				{!! Breadcrumbs::render('catalog', $bread) !!}

				<h3 class="catalog_type">
					@if(isset($bread['spec']))

						{{ $bread['spec']->title }}

					@elseif(isset($allmakes))
						
						{{ $bread['allmakes']->title }}

					@else

						{{ 'Каталог' }}
						
					@endif

				</h3>

				@include('inc.found')

			</div>

			<div class="catalog_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

@stop
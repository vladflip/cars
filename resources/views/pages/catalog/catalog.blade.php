@extends('layouts.main')

@section('body')
	
	<div class="catalog">
		
		<div class="wide-image"></div>

		<div class="container">

			<div class="catalog_left">

				@include('inc.company-signup')
				
				@include('inc.specs')

			</div>
			
			<div class="catalog_middle">

				{!! Breadcrumbs::render('catalog', $bread) !!}

				@yield('catalog')

			</div>

			<div class="catalog_right">
				
				<div class="sticky">
					@include('inc.search')
					
					@include('inc.feedback')
				</div>

			</div>

		</div>

	</div>

@stop
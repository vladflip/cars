@extends('layouts.main')

@section('body')
	
	<div class="catalog">
		
		<div class="wide-image"></div>

		<div class="container">

			<div class="catalog_left">
				
				@include('inc.specs')

			</div>
			
			<div class="catalog_middle">

				{!! Breadcrumbs::render('catalog', $bread) !!}

				<h3 class="catalog_type">
					{{ $bread ? $bread['spec']->title : 'Каталог' }}
				</h3>

				@include('inc.type')

				@include('inc.makes')

			</div>

			<div class="catalog_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

@stop
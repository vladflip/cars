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

				<div class="makes makes--catalog">

					<ul>	
					
						@foreach($models as $model)
					
							<li>
								<span>
									
									@if(isset($allmakes))
										<a href="{{ route('allmake-model', 
										['spec' => $current, 
										'make' => $make->name, 
										'model' => $model->name]) }}">
											{{ $model->title }}</a>
									@else
										<a href="{{ route('spec-make-model', 
										['spec' => $current, 
										'make' => $make->name, 
										'model' => $model->name]) }}">
											{{ $model->title }}</a>
									@endif
					
								</span>
							</li>
					
						@endforeach
						
					</ul>

				</div>

				@include('inc.found', ['make_id' => $make->id])
				
				<div class="company-popup mfp-hide" id="company-main-popup"></div>

				@include('parts.company-template')

				@include('parts.company-preview-template')

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
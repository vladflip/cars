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
				
				{{-- bread crumps --}}

				{!! Breadcrumbs::render('catalog', $bread) !!}

				<h3 class="catalog_type">
					@if(isset($bread['spec']))

						{{ $bread['spec']->title }}

					@elseif(isset($nospecs))
						
						{{ $bread['nospecs']->title }}

					@else

						{{ 'Каталог' }}
						
					@endif

				</h3>

				@if(isset($models))
					<div class="makes makes--catalog">
					
						<ul>	
						
							@foreach($models as $model)
						
								<li>
									<span>
										
										@if(isset($nospecs))
											<a href="{{ route('catalog-nospecs-model', 
											['make' => $make->name, 
											'model' => $model->name]) }}">
												{{ $model->title }}</a>
										@else
											<a href="{{ route('spec-make-model', 
											['spec' => $spec->name, 
											'make' => $make->name, 
											'model' => $model->name]) }}">
												{{ $model->title }}</a>
										@endif
						
									</span>
								</li>
						
							@endforeach
							
						</ul>
					
					</div>
				@endif

				@include('inc.found', ['make_id' => $make->id])
				
				<div class="company-popup mfp-hide" id="company-main-popup"></div>

				@include('templates.company-template')

				@include('templates.company-preview-template')

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
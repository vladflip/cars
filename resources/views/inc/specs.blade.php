<div class="specs sticky">
					
	<h3 class="specs_header">Каталог Организаций</h3>

	<ul class="specs_menu">
		
		@foreach($specs as $spec)
			
			@if($current)

				<li class="{{ $current == $spec->name ? 'specs_active' : '' }}">

			@else

				<li>

			@endif

					<a href="{{ route('specs', $spec->name) }}">
						{{ $spec->title }}
					</a>
				</li>

		@endforeach

	</ul>

	@if( ! Auth::user()->company )
		<div id="create-company-button" class="specs_add" 
		href="{{ Auth::guest() ? '#sign-up-popup' : '#create-company' }}">
			Добавить организацию
		</div>
	@endif

</div>

@if( ! Auth::user()->company )
	@include('popups.create-company')
@endif
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

	<div id="create-company-button" class="specs_add" href="#create-company">
		Добавить организацию
	</div>

</div>

@include('popups.create-company')
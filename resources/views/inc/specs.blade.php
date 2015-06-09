<div class="specs">
					
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

	<div class="specs_add">
		Добавить организацию
	</div>

</div>
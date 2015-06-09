<div class="specs">
					
	<h3 class="specs_header">Каталог Организаций</h3>

	<ul class="specs_menu">
		
		@foreach($specs as $spec)
			
			<li>{{ $spec->name }}</li>

		@endforeach

	</ul>

	<div class="specs_add">
		Добавить организацию
	</div>

</div>
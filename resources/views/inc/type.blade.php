<div class="type">
					
	@include('parts.media-header', ['title' => 'Выберите тип'])

	<ul id="type-list">

		@foreach($types as $type)

			<li class="type_item" data-id="{{ $type->id }}">
				<div>
					<img class="type_img type_img--disactive" 
					src="{{ $type->icon }}" alt="">

					<img class="type_img type_img--active" 
					src="{{ $type->icon_active }}" alt="">
				</div>
				<span>{{ $type->title }}</span>
			</li>

		@endforeach

	</ul>

</div>
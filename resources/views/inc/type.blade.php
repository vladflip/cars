<div class="type">
					
	@include('parts.media-header', ['title' => 'Выберите тип'])

	<ul id="{{ $id }}">

		@foreach($types as $type)

			<li class="type_item" data-id="{{ $type->id }}">
				<div>
					{!! $type->icon !!}
					{{-- <img class="type_img type_img--disactive" 
					src="{{ URL::to('/') . '/' . $type->icon }}" alt=""> --}}

					{{-- <img class="type_img type_img--active" 
					src="{{ URL::to('/') . '/' . $type->icon_active }}" alt=""> --}}
				</div>
				<span>{{ $type->title }}</span>
			</li>

		@endforeach

	</ul>

</div>
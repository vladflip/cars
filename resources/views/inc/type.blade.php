<div class="type">
					
	@include('parts.media-header', ['title' => 'Выберите тип'])

	<ul id="types">

		@foreach($types as $type)

			<li class="type_item" data-id="{{ $type->id }}">
				<div>
					{!! $type->icon !!}
				</div>
				<span>{{ $type->title }}</span>
			</li>

		@endforeach

	</ul>

</div>
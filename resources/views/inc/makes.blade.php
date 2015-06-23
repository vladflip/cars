<div class="makes">
	
	@include('parts.media-header', [
		'title' => isset($title) ? $title : 'Выберите производителя'
	])

	@if(isset($current_id))
		<ul id="{{ $id }}" data-current="{{ $current_id }}">
	@else
		<ul id="{{ $id }}">
	@endif
		@foreach($makes as $make)
			
				<li data-id="{{ $make->id }}">

				<span>
					{{-- when main catalog --}}
					@if(isset($allmakes))
						
						<a href="{{ route('allmakes', $make->name) }}">{{ $make->title }}</a>

					{{-- when catalog with specs --}}
					@else

						<a href="{{ route('make', ['spec' => $current, 'make' => $make->name]) }}">
							{{ $make->title }}
						</a>

					@endif

				</span>
			</li>

		@endforeach
	</ul>
	<div class="makes_empty">По данному запросу организаций не найдено</div>

</div>
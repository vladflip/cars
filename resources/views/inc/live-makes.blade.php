<div class="makes makes--live">
	
	@include('parts.media-header', ['title' => 'Выберите производителя'])

	<ul id="makes-list">
		@foreach($makes as $make)

			<li data-id="{{ $make->id }}">
				<span>
					{{ $make->title }}
				</span>
			</li>

		@endforeach
	</ul>

</div>
<div class="makes{{ isset($live) ? ' makes--live' : '' }}">
	
	@include('parts.media-header', [
		'title' => isset($title) ? $title : 'Выберите производителя'
	])

	<ul>
		@foreach($makes as $make)

			<li>
				<span>
					@if(isset($live))

						{{ $make->title }}

					@elseif(isset($allmake))
						
						<a href="{{ route('allmake', $make->name) }}">{{ $make->title }}</a>

					@else

						<a href="{{ route('make', ['spec' => $current, 'make' => $make->name]) }}">
							{{ $make->title }}
						</a>

					@endif

				</span>
			</li>

		@endforeach
	</ul>

</div>
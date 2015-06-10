<div class="makes">
	
	@include('parts.media-header', [ 'title' => $type->title ])

	<ul>
		@foreach($type->makes as $make)

			<li>
				<span>

					<a href="{{ route('feedback-make', 
						['type' => $type->name, 'make' => $make->name]) }}">
						{{ $make->title }}</a>

					<span class="makes_count" title="Количество отзывов">
						{{ count($make->feedbacks) }}
					</span>

				</span>
			</li>

		@endforeach
	</ul>

</div>
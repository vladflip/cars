<div class="makes">
	
	@include('parts.media-header', [ 'title' => $type->title ])

	<ul>
		@foreach($type->makes as $make)

			<li>
				<span>
					<span class="makes_icon" style="background-image:url({{ route('home') . '/' . $make->icon }})"></span>

					<a href="{{ route('feedback-make', 
						['type' => $type->name, 'make' => $make->name]) }}">
						{{ $make->title }}</a>

				</span>
			</li>

		@endforeach
	</ul>

</div>
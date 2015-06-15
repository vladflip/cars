<div class="parts">

	@include('parts.media-header', ['title' => 'Рубрики'])
	
	<ul id="parts-list" class="parts_categories">

		@foreach($specs as $spec)

			<li data-id="{{ $spec->id }}">
				<span>
					{{ $spec->title }}
				</span>
			</li>

		@endforeach

	</ul>

</div>
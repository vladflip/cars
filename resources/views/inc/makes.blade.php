<div class="makes{{ isset($live) ? ' makes--live' : '' }}">
	
	@include('parts.media-header', [
		'title' => isset($title) ? $title : 'Выберите производителя'
	])

	{{-- <div class="makes_count">45 компанйи</div> --}}

	<ul>
		@foreach($makes as $make)

			<li><span>{{ $make->name }}</span></li>

		@endforeach
	</ul>

</div>
<div class="makes makes--live">
	
	@include('parts.media-header', ['title' => 'Выберите производителя'])

	<ul id="main-makes-list">
		@foreach($makes as $make)

			<li data-id="{{ $make->id }}">
				<span>
					{{ $make->title }}
				</span>
			</li>

		@endforeach
	</ul>

	<div class="makes_empty">По данному запросу организаций не найдено</div>

	@include('parts.makes-template')

</div>
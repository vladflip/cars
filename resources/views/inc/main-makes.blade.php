<?php

	$got = false;

?>

<div class="makes makes--live">
	
	@include('parts.media-header', ['title' => 'Выберите производителя'])

	<ul id="main-makes-list">
		@foreach($makes as $make)

			@if(!$got && !$make->soviet)
				
				<div style="clear:both; margin-top:30px;"></div>

				<?php $got = true; ?>

			@endif

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
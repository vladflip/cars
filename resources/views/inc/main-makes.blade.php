<?php

	$soviet = [];

	$notsoviet = [];

	foreach ($makes as $make) {
		if($make->soviet)
			$soviet[] = $make;
		else
			$notsoviet[] = $make;
	}

?>

<div class="makes makes--live">
	
	@include('parts.media-header', ['title' => 'Выберите производителя'])

	<div id="main-makes-list">

		<ul>
			@foreach($soviet as $make)
			
				<li data-id="{{ $make->id }}">
					<span>
						{{ $make->title }}
					</span>
				</li>
			
			@endforeach
		</ul>

		<ul>
			@foreach($notsoviet as $make)
			
				<li data-id="{{ $make->id }}">
					<span>
						{{ $make->title }}
					</span>
				</li>
			
			@endforeach
		</ul>
		
	</div>

	<div class="makes_empty">По данному запросу организаций не найдено</div>

	@include('templates.makes-template')

</div>
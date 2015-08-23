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

<div class="makes">
	
	@include('parts.media-header', [
		'title' => isset($title) ? $title : 'Выберите производителя'
	])

	@if(isset($current_id))
		<div id="{{ $id }}" data-current="{{ $current_id }}">
	@else
		<div id="{{ $id }}">
	@endif
		<ul>
			@foreach($soviet as $make)
				
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
		<ul>
			@foreach($notsoviet as $make)
				
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
	</div>
	<div class="makes_empty">По данному запросу организаций не найдено</div>

</div>
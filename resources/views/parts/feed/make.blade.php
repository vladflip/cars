@extends('pages.feed')

@section('content')

	<h3 class="feed_header">Отзывы {{ $make->title }}</h3>
		
	<div class="makes">

		<ul>	
		
			@foreach($models as $model)
		
				<li>
					<span>
		
						<a href="">
							{{ $model->title }}</a>
		
					</span>
				</li>
		
			@endforeach
			
		</ul>

	</div>

	<div class="feed-sort">
		<span class="feed-sort_item">Сортировать по:</span>
		<div class="feed-sort_date">Дате</div>
		<div class="feed-sort_benefit feed-sort--active">Полезности</div>
	</div>

	<hr>

	@include('parts.feed.feedlist', ['feeds' => $feeds])

@stop
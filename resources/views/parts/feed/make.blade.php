@extends('pages.feed')

@section('content')

	{!! Breadcrumbs::render('feed', $bread) !!}

	<h3 class="feed_header">Отзывы {{ $make->title }}</h3>
		
	<div class="makes makes--feed">

		<ul>	
		
			@foreach($models as $model)
		
				<li>
					<span>
		
						<a href="{{ route('feedback-model', 
						['type'=>$type->name, 
						'make' => $make->name, 
						'model' => $model->name]) }}">
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
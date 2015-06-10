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
		
						<span class="makes_count" title="Количество отзывов">
							{{ count($model->feedbacks) }}
						</span>
		
					</span>
				</li>
		
			@endforeach
			
		</ul>

	</div>

	<hr>

	@include('parts.feed.feedlist', ['feeds' => $feeds])

@stop
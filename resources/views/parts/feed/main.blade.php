@extends('pages.feed')

@section('content')

	<h3 class="feed_header">Отзывы</h3>
				
	@foreach($types as $type)

		@include('inc.feed-makes', ['type' => $type])

	@endforeach

@stop
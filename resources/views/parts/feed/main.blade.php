@extends('pages.feed')

@section('content')

	<h3 class="feed_header">Отзывы</h3>
				
	@foreach($makes as $make)

		@include('inc.feed-makes', ['type' => $make])

	@endforeach

@stop
@extends('pages.feed')

@section('content')

	<h3 class="feed_header">Отзывы {{ $model->title }}</h3>

	<div class="feed-sort feed-sort--model">
		<span class="feed-sort_item">Сортировать по:</span>
		<div class="feed-sort_date">Дате</div>
		<div class="feed-sort_benefit feed-sort--active">Полезности</div>
	</div>

	<hr>

	@include('parts.feed.feedlist', ['feeds' => $feeds])

@stop
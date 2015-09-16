@extends('layouts.main')

@section('body')
	
	<div class="page">
		
		<div class="wide-image"></div>

		<div class="container">

			<div class="page_left">

				<h1>{{ $page->title }}</h1>
				
				{!! $page->content !!}

			</div>

			<div class="page_right">
				
				<div class="sticky">
					@include('inc.search')
					
					@include('inc.feedback')
				</div>

			</div>

		</div>

	</div>

@stop
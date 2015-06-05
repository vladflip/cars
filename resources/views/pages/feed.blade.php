@extends('layouts.main')

@section('body')
	
	<div class="feed">

		<div class="wide-image"></div>
		
		<div class="container">
			
			<div class="feed_left">

				<h3 class="feed_header">Отзывы</h3>
				
				@include('inc.makes', ['header' => 'Автобусы', 'count' => 1])

				@include('inc.makes', ['header' => 'Грузовики', 'count' => 2])

				@include('inc.makes', ['header' => 'Малый транспорт', 'count' => 2])

				@include('inc.makes', ['header' => 'Прицепы', 'count' => 1])

			</div>

			<div class="feed_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

@stop
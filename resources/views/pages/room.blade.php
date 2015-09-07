@extends('layouts.main')

@section('body')
	
	<div class="room">
		
		<div class="wide-image"></div>

		<div class="container">

			<div class="room_content">

				@if($company)

					@include('parts.received-requests')

				@else

					@include('parts.sent-requests')

				@endif

			</div>

		</div>

	</div>

@stop
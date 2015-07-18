<div class="received-requests">

	@foreach($requests as $request)
	
		<div class="requests_item">
			
			<div class="requests_request">
				
				<div class="requests_logo-name">

					<div class="requests_logo">
						<img src="{{ URL::to('/') . '/' . $request->user->ava }}" alt="">
					</div>

					<div class="requests_name">
						{{ $request->user->name }}
					</div>

				</div>

				<div class="requests_body requests_body--yellow">
					{{ $request->text }}
				</div>

				<div class="requests_time">
					{{ 
						$request->created_at->day . '.' . 
						$request->created_at->month . '.'.
						$request->created_at->year
					}}
				</div>

			</div>

			{{-- <div class="sent-requests_response sent-requests_response--company">
					
				<div class="requests_logo-name requests_logo-name--company">
					
					<div class="requests_logo">
						<img src="img/com_logo.jpg" alt="">
					</div>

					<div class="requests_name">
						ООО Трансавтосервис
					</div>

				</div>

				<div class="sent-requests_response-body requests_body--grey">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore est esse nesciunt optio illo tempora sapiente aspernatur recusandae. Totam, iste.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore harum porro doloribus provident, deleniti ducimus minus, repellendus.
				</div>

			</div> --}}

		</div>

	@endforeach

</div>